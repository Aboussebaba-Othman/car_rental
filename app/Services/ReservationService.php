<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Vehicle;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * Service class for managing reservations and price calculations
 */
class ReservationService
{
    /**
     * Calculate the total price and details of a reservation
     *
     * @param Vehicle $vehicle
     * @param string|Carbon $startDate
     * @param string|Carbon $endDate
     * @param int|null $promotionId
     * @return array
     */
    public function calculateReservationPrice($vehicle, $startDate, $endDate, $promotionId = null)
    {
        // Ensure dates are Carbon instances
        $startDateTime = $startDate instanceof Carbon ? $startDate : Carbon::parse($startDate);
        $endDateTime = $endDate instanceof Carbon ? $endDate : Carbon::parse($endDate);
        
        // Calculate rental duration (minimum 1 day)
        $numberOfDays = max($endDateTime->diffInDays($startDateTime), 1);
        
        // Calculate base price
        $pricePerDay = $vehicle->price_per_day;
        $subtotal = $pricePerDay * $numberOfDays;
        
        // Initialize discount variables
        $discount = 0;
        $discountPercentage = 0;
        $promotion = null;
        
        // Apply promotion if specified
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
        $subtotal = round($subtotal, 2);
        $discount = round($discount, 2);
        
        return [
            'number_of_days' => $numberOfDays,
            'price_per_day' => $pricePerDay,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'discount_percentage' => $discountPercentage,
            'total_price' => $totalPrice,
            'promotion' => $promotion
        ];
    }
    
    /**
     * Check if a vehicle is available for the given date range
     *
     * @param int $vehicleId
     * @param string|Carbon $startDate
     * @param string|Carbon $endDate
     * @return bool
     */
    public function checkVehicleAvailability($vehicleId, $startDate, $endDate)
    {
        // Format dates to strings if they are Carbon objects
        $startDateStr = $startDate instanceof Carbon ? $startDate->format('Y-m-d') : $startDate;
        $endDateStr = $endDate instanceof Carbon ? $endDate->format('Y-m-d') : $endDate;
        
        // Use caching to improve performance
        $cacheKey = "vehicle_availability_{$vehicleId}_{$startDateStr}_{$endDateStr}";
        
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($vehicleId, $startDateStr, $endDateStr) {
            $vehicle = Vehicle::findOrFail($vehicleId);
            
            // Check if vehicle is active and available
            if (!$vehicle->is_active || !$vehicle->is_available) {
                return false;
            }
            
            // Check for overlapping reservations with optimized query
            return !Reservation::where('vehicle_id', $vehicleId)
                ->whereNotIn('status', ['canceled'])
                ->where(function ($query) use ($startDateStr, $endDateStr) {
                    $query->whereBetween('start_date', [$startDateStr, $endDateStr])
                        ->orWhereBetween('end_date', [$startDateStr, $endDateStr])
                        ->orWhere(function ($q) use ($startDateStr, $endDateStr) {
                            $q->where('start_date', '<=', $startDateStr)
                              ->where('end_date', '>=', $endDateStr);
                        });
                })
                ->exists();
        });
    }
    
    /**
     * Get available dates for a vehicle within a specified range
     *
     * @param int $vehicleId
     * @param Carbon $startDate
     * @param Carbon $endDate
     * @return array
     */
    public function getAvailableDates($vehicleId, Carbon $startDate, Carbon $endDate)
    {
        $vehicle = Vehicle::findOrFail($vehicleId);
        
        // Check if vehicle is active
        if (!$vehicle->is_active || !$vehicle->is_available) {
            return [];
        }
        
        // Get all existing reservations for this vehicle in the date range
        $reservations = Reservation::where('vehicle_id', $vehicleId)
            ->whereNotIn('status', ['canceled'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                    ->orWhereBetween('end_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate->format('Y-m-d'))
                          ->where('end_date', '>=', $endDate->format('Y-m-d'));
                    });
            })
            ->get(['start_date', 'end_date']);
        
        // Create array of all dates in range
        $allDates = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate->lte($endDate)) {
            $allDates[$currentDate->format('Y-m-d')] = true;
            $currentDate->addDay();
        }
        
        // Remove unavailable dates
        foreach ($reservations as $reservation) {
            $reservationStart = Carbon::parse($reservation->start_date);
            $reservationEnd = Carbon::parse($reservation->end_date);
            
            $current = $reservationStart->copy();
            while ($current->lte($reservationEnd)) {
                $dateStr = $current->format('Y-m-d');
                if (isset($allDates[$dateStr])) {
                    $allDates[$dateStr] = false;
                }
                $current->addDay();
            }
        }
        
        // Filter to only available dates
        $availableDates = [];
        foreach ($allDates as $date => $isAvailable) {
            if ($isAvailable) {
                $availableDates[] = $date;
            }
        }
        
        return $availableDates;
    }
    
    /**
     * Clear cache related to vehicle availability
     *
     * @param int $vehicleId
     * @return void
     */
    public function clearVehicleAvailabilityCache($vehicleId = null)
    {
        if ($vehicleId) {
            // Clear specific vehicle cache
            $pattern = "vehicle_availability_{$vehicleId}_*";
            // In a real implementation, you'd use cache tags or a more sophisticated
            // method to clear specific patterns. For now, we'll use a full flush.
        }
        
        Cache::flush();
    }
}