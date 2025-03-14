<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    const USER = 1;
    const COMPANY = 2;
    const ADMIN = 3;

    public function users()
    {
        return $this->hasMany(User::class);
    }
}