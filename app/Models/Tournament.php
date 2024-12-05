<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type', 'number_of_teams'
    ];

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'tournament_team');
    }

    public function referees()
    {
        return $this->belongsToMany(User::class, 'tournament_referee', 'tournament_id', 'user_id');
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }
    public function sponsors()
    {
        return $this->belongsToMany(Sponsor::class, 'sponsor_tournament');
    }
}