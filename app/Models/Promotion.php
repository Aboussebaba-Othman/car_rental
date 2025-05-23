<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

  
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    
    public function isValid()
    {
        $today = now()->startOfDay();
        return $this->is_active 
            && $today->greaterThanOrEqualTo($this->start_date) 
            && $today->lessThanOrEqualTo($this->end_date);
    }

    
    public function appliesToVehicle($vehicleId)
    {
        return $this->applicable_vehicles === null || 
            (is_array($this->applicable_vehicles) && in_array($vehicleId, $this->applicable_vehicles));
    }
    
    public function scopeActive($query)
    {
        $today = Carbon::now()->startOfDay();
        
        return $query->where('is_active', true)
                     ->where('start_date', '<=', $today)
                     ->where('end_date', '>=', $today);
    }
}