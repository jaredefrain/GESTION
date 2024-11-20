<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'tournament_id', 'team1_id', 'team2_id', 'referee_id', 'match_date', 'location'
    ];

    protected $dates = ['match_date'];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function team1()
    {
        return $this->belongsTo(Team::class, 'team1_id');
    }

    public function team2()
    {
        return $this->belongsTo(Team::class, 'team2_id');
    }

    public function referee()
    {
        return $this->belongsTo(User::class, 'referee_id');
    }
}
