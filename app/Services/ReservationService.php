<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Vehicle;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class ReservationService
{
    
    public function calculateReservationPrice($vehicle, $startDate, $endDate, $promotionId = null)
    {
        // Ensure dates are Carbon instances
        $startDateTime = $startDate instanceof Carbon ? $startDate : Carbon::parse($startDate);
        $endDateTime = $endDate instanceof Carbon ? $endDate : Carbon::parse($endDate);
        
        // Normalize dates to midnight for consistent calculation
        $startDateTime = $startDateTime->startOfDay();
        $endDateTime = $endDateTime->startOfDay();
        
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
        
        // Log the calculation details for debugging
        Log::info('Reservation price calculation', [
            'vehicle_id' => $vehicle->id,
            'start_date' => $startDateTime->format('Y-m-d'),
            'end_date' => $endDateTime->format('Y-m-d'),
            'number_of_days' => $numberOfDays,
            'price_per_day' => $pricePerDay,
            'subtotal' => $subtotal,
            'promotion_id' => $promotionId,
            'discount' => $discount,
            'discount_percentage' => $discountPercentage,
            'total_price' => $totalPrice
        ]);
        
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
    
    public function clearVehicleAvailabilityCache($vehicleId = null)
    {
        if ($vehicleId) {
            $pattern = "vehicle_availability_{$vehicleId}_*";

        }
        
        Cache::flush();
    }
    
   
    public function recalculateAndUpdateReservationPrice(Reservation $reservation)
    {
        // Ensure the reservation is loaded with its vehicle and promotion
        if (!$reservation->relationLoaded('vehicle')) {
            $reservation->load('vehicle');
        }
        
        // Calculate reservation details
        $reservationDetails = $this->calculateReservationPrice(
            $reservation->vehicle,
            $reservation->start_date,
            $reservation->end_date,
            $reservation->promotion_id
        );
        
        // Update reservation total price if different
        if (abs($reservation->total_price - $reservationDetails['total_price']) > 0.01) {
            $oldPrice = $reservation->total_price;
            $reservation->total_price = $reservationDetails['total_price'];
            $reservation->save();
            
            Log::info('Updated reservation price', [
                'reservation_id' => $reservation->id,
                'old_price' => $oldPrice,
                'new_price' => $reservationDetails['total_price'],
                'calculation_details' => $reservationDetails
            ]);
        }
        
        return $reservationDetails['total_price'];
    }
}