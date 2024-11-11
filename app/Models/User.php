<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    const ROLE_ADMIN = 'admin';
    const ROLE_REFEREE = 'referee';
    const ROLE_COACH = 'coach';
    const ROLE_PLAYER = 'player';

    protected $fillable = [
        'name', 'email', 'password', 'role', 'age'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isReferee()
    {
        return $this->role === self::ROLE_REFEREE;
    }

    public function isCoach()
    {
        return $this->role === self::ROLE_COACH;
    }

    public function isPlayer()
    {
        return $this->role === self::ROLE_PLAYER;
    }
}