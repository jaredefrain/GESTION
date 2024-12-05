<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Tournament;
use App\Models\Team;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $finances = Finance::all();
        return view('admin.finances.index', compact('finances'));
    }

    public function create()
    {
        $tournaments = Tournament::all();
        $teams = Team::all();
        return view('admin.finances.create', compact('tournaments', 'teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'tournament_id' => 'nullable|exists:tournaments,id',
            'team_id' => 'nullable|exists:teams,id',
        ]);

        $finance = new Finance();
        $finance->type = $request->type;
        $finance->amount = $request->amount;
        $finance->description = $request->description;
        $finance->tournament_id = $request->tournament_id;
        $finance->team_id = $request->team_id;

        $finance->save();

        return redirect()->route('admin.finances.index')->with('success', 'Finance record created successfully.');
    }

    public function edit(Finance $finance)
    {
        $tournaments = Tournament::all();
        $teams = Team::all();
        return view('admin.finances.edit', compact('finance', 'tournaments', 'teams'));
    }

    public function update(Request $request, Finance $finance)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'tournament_id' => 'nullable|exists:tournaments,id',
            'team_id' => 'nullable|exists:teams,id',
        ]);

        $finance->type = $request->type;
        $finance->amount = $request->amount;
        $finance->description = $request->description;
        $finance->tournament_id = $request->tournament_id;
        $finance->team_id = $request->team_id;

        $finance->save();

        return redirect()->route('admin.finances.index')->with('success', 'Finance record updated successfully.');
    }

    public function destroy(Finance $finance)
    {
        $finance->delete();

        return redirect()->route('admin.finances.index')->with('success', 'Finance record deleted successfully.');
    }
}