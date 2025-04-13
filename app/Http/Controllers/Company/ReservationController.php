<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Vehicle;
use App\Repositories\Interfaces\ReservationRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * @var ReservationRepositoryInterface
     */
    private $reservationRepository;
    
    /**
     * ReservationController constructor.
     *
     * @param ReservationRepositoryInterface $reservationRepository
     */
    public function __construct(ReservationRepositoryInterface $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * Display a listing of the reservations.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $reservations = $this->reservationRepository->getFilteredReservations($request);
        $vehicles = Vehicle::where('company_id', Auth::user()->company_id)->get();
        
        // Get the company ID safely (could be null)
        $companyId = Auth::user() ? Auth::user()->company_id : null;
        $stats = $this->reservationRepository->getReservationStats($companyId);
        
        return view('company.reservations.index', compact('reservations', 'vehicles', 'stats'));
    }

    /**
     * Display the specified reservation.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        // Check if the reservation belongs to the company
        $this->checkReservationBelongsToCompany($reservation);
        
        // Load reservation with all relationships
        $reservation->load(['vehicle', 'user', 'promotion']);
        
        // Get previous reservations for the user
        $previousReservations = $this->reservationRepository->getPreviousReservations(
            $reservation->user_id, 
            $reservation->id
        );
        
        // Mock activities for demonstration
        $reservation->activities = $this->getMockActivities($reservation);
        
        return view('company.reservations.show', compact('reservation', 'previousReservations'));
    }
    
    /**
     * Confirm a reservation.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function confirm(Reservation $reservation)
    {
        // Check if the reservation belongs to the company
        $this->checkReservationBelongsToCompany($reservation);
        
        if ($reservation->status !== 'pending') {
            return redirect()->back()->with('error', 'This reservation cannot be confirmed because it is not in pending status.');
        }
        
        $this->reservationRepository->confirmReservation($reservation, Auth::id());
        
        return redirect()->route('company.reservations.show', $reservation)
            ->with('success', 'Reservation has been confirmed successfully.');
    }
    
    /**
     * Cancel a reservation.
     *
     * @param  \App\Models\Reservation  $reservation
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cancel(Reservation $reservation, Request $request)
    {
        // Check if the reservation belongs to the company
        $this->checkReservationBelongsToCompany($reservation);
        
        if (!in_array($reservation->status, ['pending', 'payment_pending'])) {
            return redirect()->back()->with('error', 'This reservation cannot be canceled.');
        }
        
        $reason = $request->has('cancellation_reason') ? $request->cancellation_reason : null;
        $this->reservationRepository->cancelReservation($reservation, Auth::id(), $reason);
        
        return redirect()->route('company.reservations.show', $reservation)
            ->with('success', 'Reservation has been canceled successfully.');
    }
    
    /**
     * Mark a reservation as completed.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function complete(Reservation $reservation)
    {
        // Check if the reservation belongs to the company
        $this->checkReservationBelongsToCompany($reservation);
        
        if ($reservation->status !== 'confirmed' && $reservation->status !== 'paid') {
            return redirect()->back()->with('error', 'This reservation cannot be marked as completed.');
        }
        
        $this->reservationRepository->completeReservation($reservation, Auth::id());
        
        return redirect()->route('company.reservations.show', $reservation)
            ->with('success', 'Reservation has been marked as completed.');
    }
    
    /**
     * Mark a reservation as paid.
     *
     * @param  \App\Models\Reservation  $reservation
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function markPaid(Reservation $reservation, Request $request)
    {
        // Check if the reservation belongs to the company
        $this->checkReservationBelongsToCompany($reservation);
        
        if (!in_array($reservation->status, ['pending', 'payment_pending'])) {
            return redirect()->back()->with('error', 'This reservation cannot be marked as paid.');
        }
        
        $this->reservationRepository->markReservationAsPaid($reservation);
        
        return redirect()->route('company.reservations.show', $reservation)
            ->with('success', 'Reservation has been marked as paid.');
    }
    
    /**
     * Add a note to the reservation.
     *
     * @param  \App\Models\Reservation  $reservation
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addNote(Reservation $reservation, Request $request)
    {
        // Check if the reservation belongs to the company
        $this->checkReservationBelongsToCompany($reservation);
        
        $request->validate([
            'note' => 'required|string|max:1000',
        ]);
        
        // In a real app, you would add the note to a notes table
        
        return redirect()->route('company.reservations.show', $reservation)
            ->with('success', 'Note has been added to the reservation.');
    }
    
    /**
     * Generate an invoice for the reservation.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function generateInvoice(Reservation $reservation)
    {
        // Check if the reservation belongs to the company
        $this->checkReservationBelongsToCompany($reservation);
        
        $reservation->load(['vehicle', 'user', 'promotion']);
        
        $company = Auth::user()->company;
        
        // For demonstration purposes, just return a view
        return view('company.invoices.template', compact('reservation', 'company'));
    }
    
    /**
     * Export reservations as CSV/Excel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        $reservations = $this->reservationRepository->getFilteredReservations($request, 1000);
        
        // For demonstration purposes, just return a message
        return redirect()->route('company.reservations.index')
            ->with('success', 'Export functionality would be implemented here.');
    }
    
    /**
     * Check if a reservation belongs to the company.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return void
     */
    private function checkReservationBelongsToCompany(Reservation $reservation)
    {
        $companyId = Auth::user()->company_id;
        
        if (!$this->reservationRepository->reservationBelongsToCompany($reservation, $companyId)) {
            abort(403, 'This reservation does not belong to your company.');
        }
    }
    
    /**
     * Mock activities for demonstration.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return array
     */
    private function getMockActivities(Reservation $reservation)
    {
        // In a real app, this would come from a database
        $createdAt = $reservation->created_at;
        
        $activities = [
            (object) [
                'id' => 1,
                'type' => 'status_change',
                'description' => 'Reservation created',
                'user' => $reservation->user,
                'created_at' => $createdAt,
            ],
        ];
        
        if ($reservation->status === 'payment_pending' || in_array($reservation->status, ['confirmed', 'paid', 'completed'])) {
            $activities[] = (object) [
                'id' => 2,
                'type' => 'status_change',
                'description' => 'Status changed to payment pending',
                'user' => null,
                'created_at' => $createdAt->copy()->addMinutes(5),
            ];
        }
        
        if (in_array($reservation->status, ['confirmed', 'paid', 'completed'])) {
            $activities[] = (object) [
                'id' => 3,
                'type' => 'payment',
                'description' => 'Payment received via ' . ($reservation->payment_method ?? 'PayPal'),
                'user' => null,
                'created_at' => $createdAt->copy()->addMinutes(10),
            ];
            
            $activities[] = (object) [
                'id' => 4,
                'type' => 'status_change',
                'description' => 'Status changed to confirmed',
                'user' => Auth::user(),
                'created_at' => $createdAt->copy()->addMinutes(15),
            ];
        }
        
        if ($reservation->status === 'completed') {
            $activities[] = (object) [
                'id' => 5,
                'type' => 'status_change',
                'description' => 'Reservation marked as completed',
                'user' => Auth::user(),
                'created_at' => $createdAt->copy()->addDays(1),
            ];
        }
        
        if ($reservation->status === 'canceled') {
            $activities[] = (object) [
                'id' => 6,
                'type' => 'cancellation',
                'description' => 'Reservation canceled' . ($reservation->cancellation_reason ? ': ' . $reservation->cancellation_reason : ''),
                'user' => Auth::user(),
                'created_at' => $createdAt->copy()->addMinutes(30),
            ];
        }
        
        return $activities;
    }
}