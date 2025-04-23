<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'brand',
        'model',
        'year',
        'license_plate',
        'transmission',
        'fuel_type',
        'seats',
        'price_per_day',
        'description',
        'is_active',
        'is_available',
        'features',
    ];

    protected $casts = [
        'year' => 'integer',
        'price_per_day' => 'decimal:2',
        'is_active' => 'boolean',
        'is_available' => 'boolean',
        'features' => 'array',
    ];

    /**
     * Get the company that owns the vehicle.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the photos for the vehicle.
     */
    public function photos()
    {
        return $this->hasMany(VehiclePhoto::class);
    }

    /**
     * Get the reservations for the vehicle.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->where('is_approved', true)->avg('rating') ?? 0;
    }

   
    public function isAvailableForDates($startDate, $endDate)
    {
        // First check if vehicle is marked as available and active
        if (!$this->is_available || !$this->is_active) {
            return false;
        }

        // Check if there are any overlapping reservations
        return !$this->reservations()
            ->where('status', 'confirmed')
            ->where(function ($query) use ($startDate, $endDate) {
                // Case 1: Reservation starts during requested period
                $query->whereBetween('start_date', [$startDate, $endDate])
                    // Case 2: Reservation ends during requested period
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    // Case 3: Reservation completely encompasses requested period
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->exists();
    }
}