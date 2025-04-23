<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;

// use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    
    // In your User model, make sure 'email_verified_at' is in the $fillable array
protected $fillable = [
    'role_id',
    'firstName',
    'lastName',
    'email',
    'password',
    'phone',
    'avatar',
    'is_active',
    'email_verified_at',
];

    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    
    public function company()
    {
        return $this->hasOne(Company::class);
    }

    
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    
    /**
     * Get the reservations for the user.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    
    public function isCompany()
    {
        return $this->role_id === Role::COMPANY;
    }


    public function isAdmin()
    {
        return $this->role_id === Role::ADMIN;
    }


    public function isUser()
    {
        return $this->role_id === Role::USER;
    }

    /**
     * Get the company ID safely.
     * 
     * @return int|null
     */
    public function getCompanyId()
    {
        return $this->company ? $this->company->id : null;
    }

    /**
     * Get the company ID or throw an exception if not found.
     * 
     * @return int
     * @throws \Exception
     */
    public function getCompanyIdOrFail()
    {
        if (!$this->company) {
            throw new \Exception('User has no associated company');
        }
        
        return $this->company->id;
    }

    /**
     * Check if user has an associated company.
     * 
     * @return bool
     */
    public function hasCompany()
    {
        return $this->company !== null;
    }
}