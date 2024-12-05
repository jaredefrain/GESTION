<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'referee') {
            return redirect()->route('referee.dashboard');
        } elseif ($user->role === 'player') {
            return redirect()->route('player.dashboard');
        } elseif ($user->role === 'coach') {
            return redirect()->route('coach.dashboard');
        }

        return redirect()->route('dashboard');
    }
}
