<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Mail\PaymentReminderMail;
use App\Models\Reservation;
use App\Models\Vehicle;
use App\Repositories\Interfaces\ReservationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class ReservationController extends Controller
{
    private $reservationRepository;
    
    public function __construct(ReservationRepositoryInterface $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function index(Request $request)
    {
        try {
            $reservations = $this->reservationRepository->getFilteredReservations($request);
            $vehicles = Vehicle::where('company_id', Auth::user()->company_id)->get();
            
            $companyId = Auth::user() ? Auth::user()->company_id : null;
            $stats = $this->reservationRepository->getReservationStats($companyId);
            
            return view('company.reservations.index', compact('reservations', 'vehicles', 'stats'));
        } catch (\Exception $e) {
            Log::error('Erreur lors de la récupération des réservations: ' . $e->getMessage());
            
            return view('company.reservations.index', [
                'reservations' => collect([]),
                'vehicles' => collect([]),
                'stats' => [
                    'total' => 0,
                    'confirmed' => 0,
                    'pending' => 0,
                    'revenue' => 0
                ]
            ]);
        }
    }

    public function show(Reservation $reservation)
    {
        try {
            $this->checkReservationBelongsToCompany($reservation);
            
            $reservation->load(['vehicle', 'user', 'promotion']);
            
            $previousReservations = $this->reservationRepository->getPreviousReservations(
                $reservation->user_id, 
                $reservation->id
            );
            
            $reservation->activities = $this->getMockActivities($reservation);
            
            return view('company.reservations.show', compact('reservation', 'previousReservations'));
        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'affichage d\'une réservation: ' . $e->getMessage());
            return redirect()->route('company.reservations.index')
                ->with('error', 'Impossible d\'afficher cette réservation: ' . $e->getMessage());
        }
    }
    
    public function confirm(Reservation $reservation)
    {
        try {
            $this->checkReservationBelongsToCompany($reservation);
            
            if ($reservation->status !== 'pending') {
                return redirect()->back()->with('error', 'Cette réservation ne peut pas être confirmée car elle n\'est pas en statut "en attente".');
            }
            
            $this->reservationRepository->confirmReservation($reservation, Auth::id());
            
            return redirect()->route('company.reservations.show', $reservation)
                ->with('success', 'Réservation confirmée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la confirmation: ' . $e->getMessage());
        }
    }
    
    public function cancel(Reservation $reservation, Request $request)
    {
        try {
            $this->checkReservationBelongsToCompany($reservation);
            
            if (!in_array($reservation->status, ['pending', 'payment_pending'])) {
                return redirect()->back()->with('error', 'Cette réservation ne peut pas être annulée.');
            }
            
            $reason = $request->has('cancellation_reason') ? $request->cancellation_reason : null;
            $this->reservationRepository->cancelReservation($reservation, Auth::id(), $reason);
            
            return redirect()->route('company.reservations.show', $reservation)
                ->with('success', 'Réservation annulée avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'annulation: ' . $e->getMessage());
        }
    }
    
    public function complete(Reservation $reservation)
    {
        try {
            $this->checkReservationBelongsToCompany($reservation);
            
            if ($reservation->status !== 'confirmed' && $reservation->status !== 'paid') {
                return redirect()->back()->with('error', 'Cette réservation ne peut pas être marquée comme terminée.');
            }
            
            $this->reservationRepository->completeReservation($reservation, Auth::id());
            
            return redirect()->route('company.reservations.show', $reservation)
                ->with('success', 'Réservation marquée comme terminée.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du marquage comme terminée: ' . $e->getMessage());
        }
    }
    
    public function markPaid(Reservation $reservation, Request $request)
    {
        try {
            $this->checkReservationBelongsToCompany($reservation);
            
            if (!in_array($reservation->status, ['pending', 'payment_pending'])) {
                return redirect()->back()->with('error', 'Cette réservation ne peut pas être marquée comme payée.');
            }
            
            $this->reservationRepository->markReservationAsPaid($reservation);
            
            return redirect()->route('company.reservations.show', $reservation)
                ->with('success', 'Réservation marquée comme payée.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du marquage comme payée: ' . $e->getMessage());
        }
    }
    
    public function addNote(Reservation $reservation, Request $request)
    {
        try {
            $this->checkReservationBelongsToCompany($reservation);
            
            $request->validate([
                'note' => 'required|string|max:1000',
            ]);
            
            return redirect()->route('company.reservations.show', $reservation)
                ->with('success', 'Note ajoutée à la réservation.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'ajout de la note: ' . $e->getMessage());
        }
    }
    
    public function generateInvoice(Reservation $reservation)
    {
        try {
            $this->checkReservationBelongsToCompany($reservation);
            
            $reservation->load(['vehicle', 'user', 'promotion']);
            
            $company = Auth::user()->company;
            
            return view('company.invoices.template', compact('reservation', 'company'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la génération de la facture: ' . $e->getMessage());
        }
    }
    
    public function export(Request $request)
    {
        try {
            $reservations = $this->reservationRepository->getFilteredReservations($request, 1000);
            
            return redirect()->route('company.reservations.index')
                ->with('success', 'La fonctionnalité d\'exportation serait implémentée ici.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'exportation: ' . $e->getMessage());
        }
    }
    
    public function sendPaymentReminder(Request $request, Reservation $reservation)
    {
        try {
            if ($reservation->vehicle->company_id !== Auth::user()->company->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cette réservation n\'appartient pas à votre entreprise'
                ], 403);
            }

            if (!in_array($reservation->status, ['pending', 'payment_pending'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cette réservation n\'est pas en attente de paiement'
                ], 400);
            }

            Mail::to($reservation->user->email)
                ->send(new PaymentReminderMail($reservation));

            Log::info('Payment reminder email sent', [
                'reservation_id' => $reservation->id,
                'user_id' => $reservation->user_id,
                'email' => $reservation->user->email,
                'sent_by' => Auth::id()
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Email de rappel envoyé avec succès'
                ]);
            }

            return redirect()->back()->with('success', 'Email de rappel envoyé avec succès');
        } catch (\Exception $e) {
            Log::error('Failed to send payment reminder email', [
                'reservation_id' => $reservation->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur lors de l\'envoi de l\'email: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Erreur lors de l\'envoi de l\'email: ' . $e->getMessage());
        }
    }
    
    private function checkReservationBelongsToCompany(Reservation $reservation)
    {
        if (!$reservation->relationLoaded('vehicle')) {
            $reservation->load('vehicle');
        }
        
        if (!$this->reservationRepository->authorizeVehicle($reservation->vehicle)) {
            abort(403, 'Cette réservation n\'appartient pas à votre société.');
        }
    }
    
    private function getMockActivities(Reservation $reservation)
    {
        $createdAt = $reservation->created_at;
        
        $activities = [
            (object) [
                'id' => 1,
                'type' => 'status_change',
                'description' => 'Réservation créée',
                'user' => $reservation->user ?? (object)['name' => 'Utilisateur'],
                'created_at' => $createdAt,
            ],
        ];
        
        if ($reservation->status === 'payment_pending' || in_array($reservation->status, ['confirmed', 'paid', 'completed'])) {
            $activities[] = (object) [
                'id' => 2,
                'type' => 'status_change',
                'description' => 'Statut changé en "paiement en attente"',
                'user' => null,
                'created_at' => $createdAt->copy()->addMinutes(5),
            ];
        }
        
        if (in_array($reservation->status, ['confirmed', 'paid', 'completed'])) {
            $activities[] = (object) [
                'id' => 3,
                'type' => 'payment',
                'description' => 'Paiement reçu via ' . ($reservation->payment_method ?? 'PayPal'),
                'user' => null,
                'created_at' => $createdAt->copy()->addMinutes(10),
            ];
            
            $activities[] = (object) [
                'id' => 4,
                'type' => 'status_change',
                'description' => 'Statut changé en "confirmé"',
                'user' => Auth::user() ?? (object)['name' => 'Admin'],
                'created_at' => $createdAt->copy()->addMinutes(15),
            ];
        }
        
        if ($reservation->status === 'completed') {
            $activities[] = (object) [
                'id' => 5,
                'type' => 'status_change',
                'description' => 'Réservation marquée comme terminée',
                'user' => Auth::user() ?? (object)['name' => 'Admin'],
                'created_at' => $createdAt->copy()->addDays(1),
            ];
        }
        
        if ($reservation->status === 'canceled') {
            $activities[] = (object) [
                'id' => 6,
                'type' => 'cancellation',
                'description' => 'Réservation annulée' . ($reservation->cancellation_reason ? ': ' . $reservation->cancellation_reason : ''),
                'user' => Auth::user() ?? (object)['name' => 'Admin'],
                'created_at' => $createdAt->copy()->addMinutes(30),
            ];
        }
        
        return $activities;
    }
    
}