<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id', 'team_id', 'player_id', 'goals', 'assists', 'yellow_cards', 'red_cards', 'incidents'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }
}