<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use App\Models\Tournament;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::all();
        return view('admin.sponsors.index', compact('sponsors'));
    }

    public function create()
    {
        $tournaments = Tournament::all();
        $teams = Team::all();
        return view('admin.sponsors.create', compact('tournaments', 'teams'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|url',
            'tournaments' => 'array',
            'teams' => 'array',
        ]);

        $sponsor = new Sponsor();
        $sponsor->name = $request->name;
        $sponsor->website = $request->website;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $sponsor->logo = $logoPath;
        }

        $sponsor->save();

        if ($request->has('tournaments')) {
            $sponsor->tournaments()->attach($request->tournaments);
        }

        if ($request->has('teams')) {
            $sponsor->teams()->attach($request->teams);
        }

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor created successfully.');
    }

    public function edit(Sponsor $sponsor)
    {
        $tournaments = Tournament::all();
        $teams = Team::all();
        return view('admin.sponsors.edit', compact('sponsor', 'tournaments', 'teams'));
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'website' => 'nullable|url',
            'tournaments' => 'array',
            'teams' => 'array',
        ]);

        $sponsor->name = $request->name;
        $sponsor->website = $request->website;

        if ($request->hasFile('logo')) {
            if ($sponsor->logo) {
                Storage::disk('public')->delete($sponsor->logo);
            }
            $logoPath = $request->file('logo')->store('logos', 'public');
            $sponsor->logo = $logoPath;
        }

        $sponsor->save();

        if ($request->has('tournaments')) {
            $sponsor->tournaments()->sync($request->tournaments);
        }

        if ($request->has('teams')) {
            $sponsor->teams()->sync($request->teams);
        }

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor updated successfully.');
    }

    public function destroy(Sponsor $sponsor)
    {
        if ($sponsor->logo) {
            Storage::disk('public')->delete($sponsor->logo);
        }
        $sponsor->delete();

        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor deleted successfully.');
    }
}