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

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function promotion()
    {
        return $this->belongsTo(Promotion::class);
    }

    
    public function review()
    {
        return $this->hasOne(Review::class);
    }

    
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    
    public function getDurationInDaysAttribute()
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

   
    public function canBeCanceled()
    {
        return $this->start_date->isFuture() && in_array($this->status, ['pending', 'confirmed']);
    }
}