<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Game;
use App\Models\Tournament;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Obtener los equipos del usuario autenticado
        $teamIds = $user->teams->pluck('id');

        // Obtener los próximos partidos donde el usuario es parte de uno de los equipos
        $upcomingGames = Game::whereIn('team1_id', $teamIds)
            ->orWhereIn('team2_id', $teamIds)
            ->where('match_date', '>', Carbon::now())
            ->get();

        // Obtener los torneos en los que el usuario tiene equipos
        $tournaments = Tournament::whereHas('teams', function ($query) use ($teamIds) {
            $query->whereIn('teams.id', $teamIds);
        })->with('teams')->get();

        return view('player.index', compact('upcomingGames', 'tournaments'));
    }
}