<?php
namespace App\Http\Controllers;

use App\Models\GameStatistic;
use App\Models\PlayerDetail;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CoachController extends Controller
{
    public function index(Request $request)
    {
        $coach = Auth::user();
        $teams = $coach->coachedTeams;

        $players = User::whereHas('teams', function ($query) use ($teams) {
            $query->whereIn('team_id', $teams->pluck('id'));
        })->get();

        $playerStats = GameStatistic::whereIn('player_id', $players->pluck('id'))
            ->selectRaw('player_id, SUM(goals) as total_goals, SUM(assists) as total_assists, SUM(yellow_cards) as total_yellow_cards, SUM(red_cards) as total_red_cards, COUNT(game_id) as total_games')
            ->groupBy('player_id')
            ->get();

        $bestPlayer = $playerStats->sortByDesc(function ($stat) {
            return $stat->total_goals + $stat->total_assists - ($stat->total_yellow_cards + $stat->total_red_cards);
        })->first();

        $worstPlayer = $playerStats->sortBy(function ($stat) {
            return $stat->total_goals + $stat->total_assists - ($stat->total_yellow_cards + $stat->total_red_cards);
        })->first();

        $selectedPlayer = null;
        $selectedPlayerStats = null;

        if ($request->has('player_id')) {
            $selectedPlayer = User::find($request->input('player_id'));
            $selectedPlayerStats = GameStatistic::where('player_id', $selectedPlayer->id)
                ->selectRaw('SUM(goals) as total_goals, SUM(assists) as total_assists, SUM(yellow_cards) as total_yellow_cards, SUM(red_cards) as total_red_cards, COUNT(game_id) as total_games')
                ->first();
        }

        return view('coach.dashboard', compact('playerStats', 'bestPlayer', 'worstPlayer', 'players', 'selectedPlayer', 'selectedPlayerStats'));
    }
}