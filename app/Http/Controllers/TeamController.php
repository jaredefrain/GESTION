<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        $players = User::where('role', User::ROLE_PLAYER)->get();
        return view('admin.teams.create', compact('players'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'players' => 'array',
            'players.*' => 'exists:users,id',
        ]);

        $team = new Team();
        $team->name = $request->name;

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $team->logo = $path;
        }

        $team->save();

        if ($request->has('players')) {
            $team->players()->sync($request->players);
        }

        return redirect()->route('teams.index')->with('success', 'Team created successfully.');
    }

    public function show(Team $team)
    {
        return view('admin.teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        $players = User::where('role', User::ROLE_PLAYER)->get();
        return view('admin.teams.edit', compact('team', 'players'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'players' => 'array',
            'players.*' => 'exists:users,id',
        ]);

        $team->name = $request->name;

        if ($request->hasFile('logo')) {
            if ($team->logo) {
                Storage::disk('public')->delete($team->logo);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $team->logo = $path;
        }

        $team->save();

        if ($request->has('players')) {
            $team->players()->sync($request->players);
        }

        return redirect()->route('teams.index')->with('success', 'Team updated successfully.');
    }

    public function destroy(Team $team)
    {
        if ($team->logo) {
            Storage::disk('public')->delete($team->logo);
        }
        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Team deleted successfully.');
    }

    public function removePlayer(Team $team, User $player)
    {
        $team->players()->detach($player->id);

        return redirect()->back()->with('success', 'Player removed from team successfully.');
    }
}