<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Vehicle;
use App\Models\Promotion;
use App\Services\PayPalService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ReservationController extends Controller
{
    protected $paypalService;

    public function __construct(PayPalService $paypalService)
    {
        $this->paypalService = $paypalService;
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
        
        // Check if vehicle is available
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
        
        // Check if these dates are available
        $isAvailable = $this->checkVehicleAvailability($vehicle->id, $startDate, $endDate);
        
        if (!$isAvailable) {
            return redirect()->route('home')->with('error', 'Ce véhicule n\'est pas disponible aux dates demandées.');
        }
        
        // Calculate rental duration and price
        $numberOfDays = $endDateTime->diffInDays($startDateTime) ?: 1; // At least 1 day
        
        $pricePerDay = $vehicle->price_per_day;
        $totalPrice = $pricePerDay * $numberOfDays;
        
        // Apply promotion if any
        $promotion = null;
        if ($request->has('promotion_id')) {
            $promotion = Promotion::find($request->promotion_id);
            if ($promotion && $promotion->is_active) {
                $discountAmount = $totalPrice * ($promotion->discount_percentage / 100);
                $totalPrice = max($totalPrice - $discountAmount, 0.01);
            }
        }
        
        // Format price for display
        $totalPrice = round($totalPrice, 2);
        
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
        
        // Calculate reservation details using our helper method
        $reservationDetails = $this->calculateReservationPrice(
            $vehicle,
            $validated['start_date'],
            $validated['end_date'],
            $validated['promotion_id'] ?? null
        );
        
        try {
            DB::beginTransaction();
            
            // Create the reservation
            $reservation = new Reservation();
            $reservation->user_id = Auth::id();
            $reservation->vehicle_id = $validated['vehicle_id'];
            $reservation->start_date = $validated['start_date'];
            $reservation->end_date = $validated['end_date'];
            $reservation->total_price = $reservationDetails['total_price'];
            $reservation->pickup_location = $validated['pickup_location'];
            $reservation->return_location = $validated['return_location'];
            $reservation->notes = $validated['notes'];
            $reservation->promotion_id = $validated['promotion_id'] ?? null;
            $reservation->status = 'pending';
            $reservation->save();
            
            DB::commit();
            
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
        
        // Verify and fix price if needed (added validation)
        if ($reservation->total_price <= 0) {
            // Recalculate using our helper method
            $reservationDetails = $this->calculateReservationPrice(
                $reservation->vehicle,
                $reservation->start_date,
                $reservation->end_date,
                $reservation->promotion_id
            );
            
            // Update the reservation with the correct price
            $reservation->total_price = $reservationDetails['total_price'];
            $reservation->save();
            
            Log::info('Fixed zero or negative reservation price', [
                'reservation_id' => $reservation->id,
                'new_price' => $reservation->total_price
            ]);
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
     * Calculate the total price of a reservation
     *
     * @param Vehicle $vehicle
     * @param string $startDate
     * @param string $endDate
     * @param int|null $promotionId
     * @return array
     */
    private function calculateReservationPrice($vehicle, $startDate, $endDate, $promotionId = null)
    {
        // Calculate rental duration
        $startDateTime = Carbon::parse($startDate);
        $endDateTime = Carbon::parse($endDate);
        $numberOfDays = max($endDateTime->diffInDays($startDateTime), 1); // Ensure at least 1 day
        
        // Calculate base price
        $pricePerDay = $vehicle->price_per_day;
        $subtotal = $pricePerDay * $numberOfDays;
        
        // Apply promotion if specified
        $discount = 0;
        $discountPercentage = 0;
        
        if ($promotionId) {
            $promotion = Promotion::find($promotionId);
            if ($promotion && $promotion->is_active) {
                $discountPercentage = $promotion->discount_percentage;
                $discount = $subtotal * ($discountPercentage / 100);
            }
        }
        
        // Calculate total price (ensure it's at least 0.01)
        $totalPrice = max($subtotal - $discount, 0.01);
        
        // Format for consistency
        $totalPrice = round($totalPrice, 2);
        
        return [
            'number_of_days' => $numberOfDays,
            'price_per_day' => $pricePerDay,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'discount_percentage' => $discountPercentage,
            'total_price' => $totalPrice
        ];
    }
    
    /**
     * Check if a vehicle is available for the given date range
     *
     * @param int $vehicleId
     * @param string $startDate
     * @param string $endDate
     * @return bool
     */
    private function checkVehicleAvailability($vehicleId, $startDate, $endDate)
    {
        // Use caching to improve performance
        $cacheKey = "vehicle_availability_{$vehicleId}_{$startDate}_{$endDate}";
        
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($vehicleId, $startDate, $endDate) {
            $vehicle = Vehicle::findOrFail($vehicleId);
            
            // Check if vehicle is active and available
            if (!$vehicle->is_active || !$vehicle->is_available) {
                return false;
            }
            
            // Check for overlapping reservations with optimized query
            $overlappingReservations = Reservation::where('vehicle_id', $vehicleId)
                ->whereNotIn('status', ['canceled'])
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('start_date', [$startDate, $endDate])
                        ->orWhereBetween('end_date', [$startDate, $endDate])
                        ->orWhere(function ($q) use ($startDate, $endDate) {
                            $q->where('start_date', '<=', $startDate)
                              ->where('end_date', '>=', $endDate);
                        });
                })
                ->exists();
            
            return !$overlappingReservations;
        });
    }
    
    /**
     * Clear cache related to vehicle availability
     *
     * @param int $vehicleId
     * @return void
     */
    private function clearVehicleAvailabilityCache($vehicleId)
    {
        // We can't easily clear specific cache keys with wildcard patterns,
        // so we'll use a tag-based approach in a production system.
        // For simplicity, we'll just clear entire cache in this example.
        Cache::flush();
    }
}