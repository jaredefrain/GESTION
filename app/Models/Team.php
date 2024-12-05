<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tournament;

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

    public function stadium()
    {
        return $this->hasOne(Stadium::class);
    }

    public function tournaments()
    {
        return $this->belongsToMany(Tournament::class, 'tournament_team');
    }

    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class, 'sponsor_team');
    }

}
