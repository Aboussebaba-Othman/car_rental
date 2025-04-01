<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Vehicle;
use App\Services\PayPalService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    protected $paypalService;

    public function __construct(PayPalService $paypalService)
    {
        $this->paypalService = $paypalService; // This must be inside a controller class that extends Controller
    }

    public function index()
    {
        $reservations = Reservation::with('vehicle')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('reservations.index', compact('reservations'));
    }
    
    public function create(Request $request, $vehicleId)
    {
        $vehicle = Vehicle::with('photos')->findOrFail($vehicleId);
        
        // Check if vehicle is available
        if (!$vehicle->is_available || !$vehicle->is_active) {
            return redirect()->route('home')->with('error', 'Ce véhicule n\'est pas disponible à la location.');
        }
        
        // Get dates from request or set default dates
        $startDate = $request->filled('start_date') ? $request->start_date : Carbon::now()->addDay()->format('Y-m-d');
        $endDate = $request->filled('end_date') ? $request->end_date : Carbon::now()->addDays(3)->format('Y-m-d');
        
        // Check if these dates are available
        $isAvailable = $this->checkVehicleAvailability($vehicle->id, $startDate, $endDate);
        
        if (!$isAvailable) {
            return redirect()->route('home')->with('error', 'Ce véhicule n\'est pas disponible aux dates demandées.');
        }
        
        // Calculate rental duration and price
        $startDateTime = Carbon::parse($startDate);
        $endDateTime = Carbon::parse($endDate);
        $numberOfDays = $endDateTime->diffInDays($startDateTime) ?: 1; // At least 1 day
        
        $pricePerDay = $vehicle->price_per_day;
        $totalPrice = $pricePerDay * $numberOfDays;
        
        // Apply promotion if any
        $promotion = null;
        if ($request->has('promotion_id')) {
            // You would need to fetch and validate the promotion here
            // and apply discount to totalPrice if valid
        }
        
        return view('reservations.create', compact(
            'vehicle', 
            'startDate', 
            'endDate', 
            'numberOfDays',
            'pricePerDay',
            'totalPrice',
            'promotion'
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
        ]);
        
        // Check if vehicle is available for the selected dates
        $isAvailable = $this->checkVehicleAvailability(
            $validated['vehicle_id'],
            $validated['start_date'],
            $validated['end_date']
        );
        
        if (!$isAvailable) {
            return back()->withErrors(['dates' => 'Ce véhicule n\'est pas disponible aux dates sélectionnées.'])->withInput();
        }
        
        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);
        
        // Calculate total price - ensure valid date range
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $numberOfDays = max($endDate->diffInDays($startDate), 1); // Ensure at least 1 day
        $totalPrice = $vehicle->price_per_day * $numberOfDays;
        
        // Apply promotion if provided
        if (!empty($validated['promotion_id'])) {
            $promotion = \App\Models\Promotion::find($validated['promotion_id']);
            if ($promotion && $promotion->is_active) {
                // Apply discount but ensure total price remains positive
                $discountAmount = $totalPrice * ($promotion->discount_percentage / 100);
                $totalPrice = max($totalPrice - $discountAmount, 0.01); // Ensure at least 0.01
            }
        }
        
        try {
            DB::beginTransaction();
            
            // Create the reservation
            $reservation = new Reservation();
            $reservation->user_id = Auth::id();
            $reservation->vehicle_id = $validated['vehicle_id'];
            $reservation->start_date = $validated['start_date'];
            $reservation->end_date = $validated['end_date'];
            $reservation->total_price = round($totalPrice, 2); // Round to 2 decimal places
            $reservation->pickup_location = $validated['pickup_location'];
            $reservation->return_location = $validated['return_location'];
            $reservation->notes = $validated['notes'];
            $reservation->promotion_id = $validated['promotion_id'] ?? null;
            $reservation->status = 'pending';
            $reservation->save();
            
            DB::commit();
            
            return redirect()->route('reservations.payment', $reservation);
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Reservation creation failed', ['error' => $e->getMessage()]);
            
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la création de votre réservation.'])->withInput();
        }
    }
    
    public function show(Reservation $reservation)
    {
        // Ensure user can only view their own reservations
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
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
        
        return view('reservations.payment', compact('reservation'));
    }
    
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
        
        // Add price validation and fix if needed
        if ($reservation->total_price <= 0) {
            // Calculate price again to ensure it's correct
            $vehicle = Vehicle::findOrFail($reservation->vehicle_id);
            $startDate = Carbon::parse($reservation->start_date);
            $endDate = Carbon::parse($reservation->end_date);
            $numberOfDays = max($endDate->diffInDays($startDate), 1); // Ensure at least 1 day
            $totalPrice = $vehicle->price_per_day * $numberOfDays;
            
            // Apply promotion if specified
            if ($reservation->promotion_id) {
                $promotion = \App\Models\Promotion::find($reservation->promotion_id);
                if ($promotion && $promotion->is_active) {
                    // Apply discount but ensure total price remains positive
                    $discountAmount = $totalPrice * ($promotion->discount_percentage / 100);
                    $totalPrice = max($totalPrice - $discountAmount, 0.01); // Ensure at least 0.01
                }
            }
            
            // Update the reservation with the correct price
            $reservation->total_price = round($totalPrice, 2); // Round to 2 decimal places
            $reservation->save();
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
        
        if (empty($token) || empty($payerId) || $reservation->payment_id !== $token) {
            return redirect()->route('reservations.payment', $reservation)
                ->with('error', 'Erreur lors de la validation du paiement.');
        }
        
        $response = $this->paypalService->capturePayment($reservation->payment_id, $reservation);
        
        if ($response['success']) {
            return redirect()->route('reservations.show', $reservation)
                ->with('success', 'Votre paiement a été traité avec succès. Votre réservation est confirmée!');
        } else {
            return redirect()->route('reservations.payment', $reservation)
                ->with('error', 'Erreur lors de la capture du paiement: ' . ($response['message'] ?? 'Erreur inconnue'));
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
        
        return redirect()->route('reservations.index')
            ->with('success', 'Votre réservation a été annulée avec succès.');
    }
    
    private function checkVehicleAvailability($vehicleId, $startDate, $endDate)
    {
        $vehicle = Vehicle::findOrFail($vehicleId);
        
        // Check if vehicle is active and available
        if (!$vehicle->is_active || !$vehicle->is_available) {
            return false;
        }
        
        // Check for overlapping reservations
        $overlappingReservations = Reservation::where('vehicle_id', $vehicleId)
            ->where('status', '!=', 'canceled')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '<=', $startDate)
                      ->where('end_date', '>=', $startDate);
                })->orWhere(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '<=', $endDate)
                      ->where('end_date', '>=', $endDate);
                })->orWhere(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '>=', $startDate)
                      ->where('end_date', '<=', $endDate);
                });
            })
            ->exists();
        
        return !$overlappingReservations;
    }
}
