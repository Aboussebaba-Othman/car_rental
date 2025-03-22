<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'discount_percentage',
        'start_date',
        'end_date',
        'is_active',
        'applicable_vehicles',
    ];

    protected $casts = [
        'discount_percentage' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'applicable_vehicles' => 'array',
    ];

    /**
     * Get the company that owns the promotion.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the reservations that use this promotion.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Check if the promotion is currently valid
     */
    public function isValid()
    {
        $today = now()->startOfDay();
        return $this->is_active 
            && $today->greaterThanOrEqualTo($this->start_date) 
            && $today->lessThanOrEqualTo($this->end_date);
    }

    /**
     * Check if the promotion applies to a specific vehicle
     */
    public function appliesToVehicle($vehicleId)
    {
        return $this->applicable_vehicles === null || 
            (is_array($this->applicable_vehicles) && in_array($vehicleId, $this->applicable_vehicles));
    }
}