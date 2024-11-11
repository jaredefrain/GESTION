<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RefereeController extends Controller
{
    public function index()
    {
        return view('referee.index');
    }
}