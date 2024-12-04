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
        $teams = Team::with('players', 'coaches')->get();
        $coaches = User::where('role', User::ROLE_COACH)->get();
        return view('admin.teams.index', compact('teams', 'coaches'));
    }

    public function create()
    {
        // Filtrar jugadores que no tienen equipo y que tienen el rol de jugador
        $players = User::where('role', User::ROLE_PLAYER)
                       ->whereDoesntHave('teams')
                       ->get();

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
            $logoPath = $request->file('logo')->store('logos', 'public');
            $team->logo = $logoPath;
        }

        $team->save();

        if ($request->has('players')) {
            $team->players()->attach($request->players);
        }

        return redirect()->route('teams.index')->with('success', 'Equipo creado exitosamente.');
    }

    public function show(Team $team)
    {
        return view('admin.teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        // Filtrar jugadores que no tienen equipo y que tienen el rol de jugador
        $availablePlayers = User::where('role', User::ROLE_PLAYER)
                                ->whereDoesntHave('teams')
                                ->get();

        // Obtener los jugadores que ya están en el equipo
        $teamPlayers = $team->players;

        // Combinar ambos conjuntos de jugadores
        $players = $availablePlayers->merge($teamPlayers);

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

        return redirect()->route('teams.index')->with('success', 'Equipo actualizado exitosamente.');
    }

    public function destroy(Team $team)
    {
        if ($team->logo) {
            Storage::disk('public')->delete($team->logo);
        }
        $team->delete();

        return redirect()->route('teams.index')->with('success', 'Equipo eliminado exitosamente.');
    }

    public function removePlayer(Team $team, User $player)
    {
        $team->players()->detach($player->id);

        return redirect()->back()->with('success', 'Jugador eliminado del equipo exitosamente.');
    }

    public function assignCoach(Request $request, Team $team)
    {
        $request->validate([
            'coaches' => 'required|array',
            'coaches.*' => 'exists:users,id',
        ]);

        $team->coaches()->sync($request->coaches);

        return redirect()->route('teams.index')->with('success', 'Entrenadores asignados exitosamente.');
    }
}