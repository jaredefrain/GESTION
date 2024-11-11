<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    public function index()
    {
        return view('player.index');
    }
}

