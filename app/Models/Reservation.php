<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vehicle_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'pickup_location',
        'return_location',
        'notes',
        'promotion_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the user that owns the reservation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the vehicle that is reserved.
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the promotion applied to the reservation.
     */
    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    /**
     * Get the reviews for the reservation.
     */
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    /**
     * Get the messages related to the reservation.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Calculate the number of days between start and end date
     */
    public function getDurationInDaysAttribute()
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    /**
     * Check if the reservation can be canceled
     */
    public function canBeCanceled()
    {
        // Example: Can be canceled if reservation is not yet started and is in pending or confirmed status
        return $this->start_date->isFuture() && in_array($this->status, ['pending', 'confirmed']);
    }
}