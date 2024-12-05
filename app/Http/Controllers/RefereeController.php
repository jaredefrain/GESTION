<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Tournament;
use Illuminate\Support\Facades\Auth;

class RefereeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Obtener los partidos que ha pitado el árbitro autenticado
        $refereedGames = Game::where('referee_id', $user->id)->get();
        
        // Obtener estadísticas de los partidos
        $totalGames = $refereedGames->count();
        $totalTeams = $refereedGames->pluck('team1_id')->merge($refereedGames->pluck('team2_id'))->unique()->count();
        $totalTournaments = $refereedGames->pluck('tournament_id')->unique()->count();

        return view('referee.index', compact('refereedGames', 'totalGames', 'totalTeams', 'totalTournaments'));
    }
}