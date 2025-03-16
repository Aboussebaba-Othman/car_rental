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

    
    protected $fillable = [
        'role_id',
        'firstName',
        'lastName',
        'email',
        'password',
        'phone',
        'avatar',
        'is_active'
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
}