<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PlayerDetail;
use Illuminate\Http\Request;

class PlayerDetailController extends Controller
{
    public function index()
    {
        $playerDetails = PlayerDetail::with('user')->get();
        return view('admin.player.details.index', compact('playerDetails'));
    }

    public function create()
    {
        $players = User::where('role', 'player')->get();
        return view('admin.player.details.create', compact('players'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'height' => 'required|numeric',
            'position' => 'required|string|max:255',
            'goals' => 'required|numeric',
            'assists' => 'required|numeric',
            'yellow_cards' => 'required|numeric',
            'red_cards' => 'required|numeric',
        ]);

        $selectedUser = User::findOrFail($request->user_id);

        $selectedUser->playerDetail()->create(
            $request->only('height', 'position', 'goals', 'assists', 'yellow_cards', 'red_cards')
        );

        return redirect()->route('admin.player.details.index')->with('success', 'Player details created successfully.');
    }

    public function edit(User $user)
    {
        $playerDetail = $user->playerDetail ?? new PlayerDetail();
        return view('admin.player.details.edit', compact('user', 'playerDetail'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'height' => 'required|numeric',
            'position' => 'required|string|max:255',
            'goals' => 'required|numeric',
            'assists' => 'required|numeric',
            'yellow_cards' => 'required|numeric',
            'red_cards' => 'required|numeric',
        ]);

        $user->playerDetail()->updateOrCreate(
            ['user_id' => $user->id],
            $request->only('height', 'position', 'goals', 'assists', 'yellow_cards', 'red_cards')
        );

        return redirect()->route('admin.player.details.index')->with('success', 'Player details updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->playerDetail()->delete();
        return redirect()->route('admin.player.details.index')->with('success', 'Player details deleted successfully.');
    }
}
