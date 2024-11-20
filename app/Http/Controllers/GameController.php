<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Team;
use App\Models\User;
use App\Models\Tournament;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with(['team1', 'team2', 'referee', 'tournament'])->get();
        return view('admin.games.index', compact('games'));
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
    
    
}
