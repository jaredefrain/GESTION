<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo'];

    public function players()
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id');
    }

    public function coaches()
    {
        return $this->belongsToMany(User::class, 'team_coach', 'team_id', 'coach_id');
    }

    public function teams()

    {

        return $this->hasMany(Team::class);

    }
}
