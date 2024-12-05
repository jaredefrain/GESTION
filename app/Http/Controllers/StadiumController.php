<?php

namespace App\Http\Controllers;

use App\Models\Stadium;
use App\Models\Team;
use Illuminate\Http\Request;

class StadiumController extends Controller
{
    public function index()
    {
        $stadiums = Stadium::with('team')->get();
        return view('stadiums.index', compact('stadiums'));
    }

    public function create()
    {
        $teams = Team::doesntHave('stadium')->pluck('name', 'id');
        return view('stadiums.create', compact('teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'has_event' => 'required|boolean',
            'event_start' => 'nullable|date',
            'event_end' => 'nullable|date',
            'team_id' => 'required|exists:teams,id|unique:stadiums,team_id',
        ]);

        Stadium::create($request->all());

        return redirect()->route('stadiums.index')->with('success', 'Estadio creado exitosamente.');
    }

    public function edit(Stadium $stadium)
    {
        $teams = Team::doesntHave('stadium')->orWhere('id', $stadium->team_id)->pluck('name', 'id');
        return view('stadiums.edit', compact('stadium', 'teams'));
    }

    public function update(Request $request, Stadium $stadium)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'has_event' => 'required|boolean',
            'event_start' => 'nullable|date',
            'event_end' => 'nullable|date',
            'team_id' => 'required|exists:teams,id|unique:stadiums,team_id,' . $stadium->id,
        ]);

        if ($request->has_event == 0) {
            $request->merge(['event_start' => null, 'event_end' => null]);
        }

        $stadium->update($request->all());

        return redirect()->route('stadiums.index')->with('success', 'Estadio actualizado exitosamente.');
    }

    public function destroy(Stadium $stadium)
    {
        $stadium->delete();

        return redirect()->route('stadiums.index')->with('success', 'Estadio eliminado exitosamente.');
    }
}