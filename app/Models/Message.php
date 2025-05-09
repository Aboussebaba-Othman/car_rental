<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'content',
        'is_read',
        'sender_type', 
        'reservation_id'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

   
    public function getSenderNameAttribute()
    {
        return $this->sender_type == 'user' 
            ? $this->user->name 
            : $this->company->name;
    }
}