<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\User;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\GameStatistic;
class GameController extends Controller
{
    public function index()
    {
        $games = Game::all()->map(function ($game) {
            $game->match_date = Carbon::parse($game->match_date);
            return $game;
        });

        $tournaments = Tournament::all();
        return view('admin.games.index', compact('games', 'tournaments'));
    }
    public function create()
    {
        $teams = Team::all();
        $referees = User::where('role', 'referee')->get();
        $tournaments = Tournament::all();
        return view('admin.games.create', compact('teams', 'referees', 'tournaments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'team1_id' => 'required|exists:teams,id|different:team2_id',
            'team2_id' => 'required|exists:teams,id',
            'referee_id' => 'required|exists:users,id',
            'match_date' => 'required|date',
            'location' => 'required|string|max:255',
        ]);

        Game::create($request->all());

        return redirect()->route('admin.games.index')->with('success', 'Game created successfully.');
    }
    public function edit(Game $game)
    {
        $teams = Team::all();
        $referees = User::where('role', 'referee')->get();
        $tournaments = Tournament::all();
        return view('admin.games.edit', compact('game', 'teams', 'referees', 'tournaments'));
    }

    public function update(Request $request, Game $game)
    {
        $request->validate([
            'tournament_id' => 'required|exists:tournaments,id',
            'team1_id' => 'required|exists:teams,id|different:team2_id',
            'team2_id' => 'required|exists:teams,id',
            'referee_id' => 'required|exists:users,id',
            'match_date' => 'required|date',
            'location' => 'required|string|max:255',
        ]);

        $game->update($request->all());

        return redirect()->route('admin.games.index')->with('success', 'Game updated successfully.');
    }

    public function destroy(Game $game)
    {
        $game->delete();
        return redirect()->route('admin.games.index')->with('success', 'Game deleted successfully.');
    }


    public function manage(Game $game)
    {
        $teams = Team::all();
        $players = User::whereHas('teams')->get();
        $statistics = GameStatistic::where('game_id', $game->id)->get();
    
        $team1Goals = $statistics->where('team_id', $game->team1_id)->sum('goals');
        $team2Goals = $statistics->where('team_id', $game->team2_id)->sum('goals');
    
        return view('admin.games.manage', compact('game', 'teams', 'players', 'statistics', 'team1Goals', 'team2Goals'));
    }
    public function storeStatistics(Request $request, Game $game)
    {
        $request->validate([
            'team_id' => 'required|exists:teams,id',
            'player_id' => 'required|exists:users,id',
            'goals' => 'required|integer|min:0',
            'assists' => 'required|integer|min:0',
            'yellow_cards' => 'required|integer|min:0',
            'red_cards' => 'required|integer|min:0',
            'incidents' => 'nullable|string',
        ]);

        GameStatistic::create([
            'game_id' => $game->id,
            'team_id' => $request->team_id,
            'player_id' => $request->player_id,
            'goals' => $request->goals,
            'assists' => $request->assists,
            'yellow_cards' => $request->yellow_cards,
            'red_cards' => $request->red_cards,
            'incidents' => $request->incidents,
        ]);

        return redirect()->route('admin.games.manage', $game->id)->with('success', 'Estadísticas del partido actualizadas correctamente.');
    }
}
