<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoachController extends Controller
{
    public function index()
    {
        $coach = Auth::user();
        $team = $coach->teams()->first();
        $games = Game::where('team1_id', $team->id)
                    ->orWhere('team2_id', $team->id)
                    ->orderBy('match_date', 'desc')
                    ->get();
        $players = $team->players;

        return view('coach.dashboard', compact('team', 'games', 'players'));
    }
}