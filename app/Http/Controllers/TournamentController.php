<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\Team;
use App\Models\User;
use App\Models\Game;
use Carbon\Carbon;
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
    public function generateFixtures(Tournament $tournament)
{
    $teams = $tournament->teams;
    $numberOfTeams = $teams->count();
    $fixtures = [];

    if ($tournament->type == 'liga') {
        // Generate round-robin fixtures
        for ($i = 0; $i < $numberOfTeams - 1; $i++) {
            for ($j = $i + 1; $j < $numberOfTeams; $j++) {
                $fixtures[] = [
                    'team1_id' => $teams[$i]->id,
                    'team2_id' => $teams[$j]->id,
                    'tournament_id' => $tournament->id,
                    'match_date' => Carbon::now()->addDays(rand(1, 30)), // Example date
                    'location' => 'Stadium ' . rand(1, 5), // Example location
                    'referee_id' => $tournament->referees->random()->id,
                ];
            }
        }
    }

    // Save fixtures to the database
    foreach ($fixtures as $fixture) {
        Game::create($fixture);
    }

    $fixtures = Game::where('tournament_id', $tournament->id)->get();

    return view('admin.tournaments.fixtures', compact('tournament', 'fixtures'))->with('success', 'Fixtures generated successfully.');
}
}
