<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'company_name',
        'address',
        'city',
        'legal_documents',
        'is_validated'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_validated' => 'boolean',
        'legal_documents' => 'array',
    ];

    /**
     * Get the user that owns the company.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all users associated with this company.
     * This relationship allows a company to have multiple user accounts.
     */
    public function users()
    {

        return $this->belongsTo(User::class, 'user_id');
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

   
    public function reservations()
    {
        return $this->hasManyThrough(Reservation::class, Vehicle::class);
    }

    
    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}