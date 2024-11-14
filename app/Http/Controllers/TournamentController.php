<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function index()
    {
        $tournaments = Tournament::all();
        return view('admin.tournaments.index', compact('tournaments'));
    }

    public function create()
    {
        $teams = Team::all();
        $referees = User::where('role', 'referee')->get();
        return view('admin.tournaments.create', compact('teams', 'referees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:eliminatorias,liga,mixto',
            'number_of_teams' => 'required|integer|min:2',
            'teams' => 'required|array',
            'referees' => 'required|array',
        ]);

        $tournament = Tournament::create($request->only('name', 'type', 'number_of_teams'));

        $tournament->teams()->attach($request->teams);
        $tournament->referees()->attach($request->referees);

        return redirect()->route('admin.tournaments.index')->with('success', 'Tournament created successfully.');
    }

    public function show(Tournament $tournament)
    {
        return view('admin.tournaments.show', compact('tournament'));
    }

    public function edit(Tournament $tournament)
    {
        $teams = Team::all();
        $referees = User::where('role', 'referee')->get();
        return view('admin.tournaments.edit', compact('tournament', 'teams', 'referees'));
    }

    public function update(Request $request, Tournament $tournament)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:eliminatorias,liga,mixto',
            'number_of_teams' => 'required|integer|min:2',
            'teams' => 'required|array',
            'referees' => 'required|array',
        ]);

        $tournament->update($request->only('name', 'type', 'number_of_teams'));

        $tournament->teams()->sync($request->teams);
        $tournament->referees()->sync($request->referees);

        return redirect()->route('admin.tournaments.index')->with('success', 'Tournament updated successfully.');
    }

    public function destroy(Tournament $tournament)
    {
        $tournament->delete();
        return redirect()->route('admin.tournaments.index')->with('success', 'Tournament deleted successfully.');
    }
}