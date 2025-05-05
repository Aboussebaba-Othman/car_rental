<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Vehicle;
use App\Models\Promotion;
use App\Services\PayPalService;
use App\Services\ReservationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    protected $paypalService;
    protected $reservationService;

    public function __construct(PayPalService $paypalService, ReservationService $reservationService)
    {
        $this->paypalService = $paypalService;
        $this->reservationService = $reservationService;
    }

    public function index()
    {
        $reservations = Reservation::with(['vehicle', 'vehicle.photos', 'promotion'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('reservations.index', compact('reservations'));
    }
    
    public function create(Request $request, $vehicleId)
    {
        $vehicle = Vehicle::with(['photos'])->findOrFail($vehicleId);
        
        // Check if vehicle is available (only check if it's active, not date availability)
        if (!$vehicle->is_available || !$vehicle->is_active) {
            return redirect()->route('home')->with('error', 'Ce véhicule n\'est pas disponible à la location.');
        }
        
        // Get dates from request or set default dates
        $startDate = $request->filled('start_date') ? $request->start_date : Carbon::now()->addDay()->format('Y-m-d');
        $endDate = $request->filled('end_date') ? $request->end_date : Carbon::now()->addDays(3)->format('Y-m-d');
        
        // Validate date range
        $startDateTime = Carbon::parse($startDate);
        $endDateTime = Carbon::parse($endDate);
        
        if ($startDateTime->isAfter($endDateTime)) {
            $endDate = $startDateTime->copy()->addDays(1)->format('Y-m-d');
            $endDateTime = Carbon::parse($endDate);
        }
        
        // We no longer check vehicle availability here - let the user choose dates
        // in the availability calendar instead
        
        // Get promotion if applicable
        $promotionId = $request->has('promotion_id') ? $request->promotion_id : null;
        $promotion = null;
        
        if ($promotionId) {
            $promotion = Promotion::find($promotionId);
            if (!$promotion || !$promotion->is_active) {
                $promotionId = null;
            }
        }
        
        // Calculate reservation details using the service
        $reservationDetails = $this->reservationService->calculateReservationPrice(
            $vehicle,
            $startDate,
            $endDate,
            $promotionId
        );
        
        $numberOfDays = $reservationDetails['number_of_days'];
        $pricePerDay = $reservationDetails['price_per_day'];
        $totalPrice = $reservationDetails['total_price'];
        $promotion = $reservationDetails['promotion'];
        
        // Get the available promotions that could apply to this vehicle
        $availablePromotions = Promotion::active()->get()->filter(function($promo) use ($vehicle) {
            return $promo->applicable_vehicles === null || 
                   (is_array($promo->applicable_vehicles) && in_array($vehicle->id, $promo->applicable_vehicles));
        });
        
        return view('reservations.create', compact(
            'vehicle', 
            'startDate', 
            'endDate', 
            'numberOfDays',
            'pricePerDay',
            'totalPrice',
            'promotion',
            'availablePromotions'
        ));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'pickup_location' => 'required|string|max:255',
            'return_location' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'promotion_id' => 'nullable|exists:promotions,id',
            'total_price' => 'required|numeric|min:0.01',
        ]);
        
        // Vérifier la disponibilité du véhicule
        $isAvailable = $this->reservationService->checkVehicleAvailability(
            $validated['vehicle_id'],
            $validated['start_date'],
            $validated['end_date']
        );
        
        if (!$isAvailable) {
            return back()->withErrors(['dates' => 'Ce véhicule n\'est pas disponible aux dates sélectionnées.'])->withInput();
        }
        
        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);
        
        try {
            DB::beginTransaction();
            
            // Créer la réservation
            $reservation = new Reservation();
            $reservation->user_id = Auth::id();
            $reservation->vehicle_id = $validated['vehicle_id'];
            $reservation->start_date = $validated['start_date'];
            $reservation->end_date = $validated['end_date'];
            // Utiliser DIRECTEMENT le prix soumis sans recalcul ni comparaison
            $reservation->total_price = $validated['total_price']; 
            $reservation->pickup_location = $validated['pickup_location'];
            $reservation->return_location = $validated['return_location'];
            $reservation->notes = $validated['notes'];
            $reservation->promotion_id = $validated['promotion_id'] ?? null;
            $reservation->status = 'pending';
            $reservation->save();
            
            DB::commit();
            
            // Pour le débogage
            Log::info('Reservation created', [
                'reservation_id' => $reservation->id,
                'total_price' => $reservation->total_price,
                'submitted_price' => $validated['total_price']
            ]);
            
            return redirect()->route('reservations.payment', $reservation)
                ->with('success', 'Votre réservation a été créée avec succès. Veuillez procéder au paiement pour la confirmer.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Reservation creation failed', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la création de votre réservation.'])->withInput();
        }
    }
    
    public function show(Reservation $reservation)
    {
        // Ensure user can only view their own reservations
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Eager load related data to reduce database queries
        $reservation->load(['vehicle', 'vehicle.photos', 'promotion']);
        
        return view('reservations.show', compact('reservation'));
    }
    
    public function payment(Reservation $reservation)
    {
        // Ensure user can only access their own reservations
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if reservation is in a payable state
        if (!in_array($reservation->status, ['pending', 'payment_pending'])) {
            return redirect()->route('reservations.show', $reservation)
                ->with('error', 'Cette réservation ne peut pas être payée dans son état actuel.');
        }
        
        // Eager load related data
        $reservation->load(['vehicle', 'vehicle.photos', 'promotion']);
        
        // Ne pas recalculer le prix ici pour éviter de l'écraser
        // $this->reservationService->recalculateAndUpdateReservationPrice($reservation);
        
        // Calculate number of days for the view - ensure consistent calculation
        $startDate = Carbon::parse($reservation->start_date)->startOfDay();
        $endDate = Carbon::parse($reservation->end_date)->startOfDay();
        $numberOfDays = max($endDate->diffInDays($startDate) + 1, 1); // Ensure at least 1 day
        
        // Log calculation details for debugging
        Log::info('Payment page calculation', [
            'reservation_id' => $reservation->id,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'number_of_days' => $numberOfDays,
            'total_price' => $reservation->total_price
        ]);
        
        return view('reservations.payment', compact('reservation', 'numberOfDays'));
    }
    
    /**
     * Traite le paiement PayPal pour une réservation
     */
    public function processPayPal(Reservation $reservation)
    {
        // Ensure user can only pay their own reservations
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if reservation is in a payable state
        if (!in_array($reservation->status, ['pending', 'payment_pending'])) {
            return redirect()->route('reservations.show', $reservation)
                ->with('error', 'Cette réservation ne peut pas être payée dans son état actuel.');
        }
        
        // Log the reservation details for debugging
        Log::info('Processing PayPal payment', [
            'reservation_id' => $reservation->id,
            'total_price' => $reservation->total_price,
            'user_id' => $reservation->user_id,
            'vehicle_id' => $reservation->vehicle_id,
            'dates' => $reservation->start_date . ' to ' . $reservation->end_date
        ]);
        
        $response = $this->paypalService->createOrder($reservation);
        
        if ($response['success']) {
            return redirect()->away($response['approval_url']);
        } else {
            return redirect()->route('reservations.payment', $reservation)
                ->with('error', 'Erreur lors de la création du paiement PayPal: ' . ($response['message'] ?? 'Erreur inconnue'));
        }
    }
    
    
    public function paypalSuccess(Request $request, Reservation $reservation)
    {
        // Validate PayPal payment
        $token = $request->query('token');
        $payerId = $request->query('PayerID');
        
        // Log detailed information
        Log::info('PayPal success callback', [
            'reservation_id' => $reservation->id,
            'token' => $token,
            'payer_id' => $payerId,
            'stored_payment_id' => $reservation->payment_id
        ]);
        
        if (empty($token)) {
            Log::error('PayPal callback missing token', ['request' => $request->all()]);
            return redirect()->route('reservations.payment', $reservation)
                ->with('error', 'Erreur lors de la validation du paiement: Token manquant.');
        }
        
        // Check if payment_id exists but doesn't match token (could be stored incorrectly)
        if (!empty($reservation->payment_id) && $reservation->payment_id !== $token) {
            Log::warning('Payment ID mismatch, using callback token', [
                'token' => $token,
                'stored_payment_id' => $reservation->payment_id
            ]);
        }
        
        // Try with cURL method first as it's more robust
        $response = $this->paypalService->capturePaymentWithCurl($token, $reservation);
        
        // If the first method fails, try the original method as a fallback
        if (!$response['success'] && isset($response['message']) && 
            strpos($response['message'], 'Connection error') !== false) {
            Log::warning('Falling back to original capture method', ['token' => $token]);
            $response = $this->paypalService->capturePayment($token, $reservation);
        }
        
        if ($response['success']) {
            // Clear any cache related to vehicle availability
            $this->clearVehicleAvailabilityCache($reservation->vehicle_id);
            
            return redirect()->route('reservations.show', $reservation)
                ->with('success', 'Votre paiement a été traité avec succès. Votre réservation est confirmée!');
        } else {
            // Log detailed error
            Log::error('PayPal capture failed in controller', $response);
            
            // Provide a more informative error message to the user
            $errorMessage = 'Erreur lors de la capture du paiement';
            if (isset($response['message'])) {
                $errorMessage .= ': ' . $response['message'];
            }
            
            // Add troubleshooting instructions for sandbox mode
            if (config('services.paypal.mode') === 'sandbox' && config('app.env') !== 'production') {
                $errorMessage .= '. En mode test, assurez-vous que vous utilisez un compte sandbox valide et que l\'API PayPal est disponible.';
            }
            
            return redirect()->route('reservations.payment', $reservation)
                ->with('error', $errorMessage);
        }
    }
    
    public function paypalCancel(Reservation $reservation)
    {
        return redirect()->route('reservations.payment', $reservation)
            ->with('warning', 'Le paiement PayPal a été annulé. Vous pouvez réessayer de payer ou choisir une autre méthode de paiement.');
    }
    
    public function cancel(Reservation $reservation)
    {
        // Ensure user can only cancel their own reservations
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Only pending or payment_pending reservations can be cancelled
        if (!in_array($reservation->status, ['pending', 'payment_pending'])) {
            return redirect()->route('reservations.show', $reservation)
                ->with('error', 'Cette réservation ne peut pas être annulée dans son état actuel.');
        }
        
        $reservation->status = 'canceled';
        $reservation->save();
        
        // Clear any cache related to vehicle availability
        $this->clearVehicleAvailabilityCache($reservation->vehicle_id);
        
        return redirect()->route('reservations.index')
            ->with('success', 'Votre réservation a été annulée avec succès.');
    }
    
    /**
     * Clear cache related to vehicle availability
     *
     * @param int $vehicleId
     * @return void
     */
    private function clearVehicleAvailabilityCache($vehicleId)
    {
        $this->reservationService->clearVehicleAvailabilityCache($vehicleId);
    }
}