<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RefereeController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\PlayerDetailController;

// Middleware de autenticación
Route::middleware(['auth'])->group(function () {

    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/admin/{user}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::put('/admin/{user}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/admin/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');
    });

    // Rutas para el árbitro
    Route::middleware(['auth', 'role:referee'])->group(function () {
        Route::get('/referee', [RefereeController::class, 'index'])->name('referee.dashboard');
    });

    // Rutas para el jugador
    Route::middleware('role:player')->group(function () {
        Route::get('/player', [PlayerController::class, 'index'])->name('player.dashboard');
    });

    // Rutas para el entrenador
    Route::middleware('role:coach')->group(function () {
        Route::get('/coach', [CoachController::class, 'index'])->name('coach.dashboard');
    });

    // Rutas para el perfil de usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Ruta del dashboard, protegida por autenticación y verificación
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
});

// Rutas para la gestión de equipos por el admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('teams', TeamController::class);
    Route::delete('teams/{team}/players/{player}', [TeamController::class, 'removePlayer'])->name('teams.removePlayer');
});

// Ruta de bienvenida
Route::get('/', function () {
    return view('welcome');
});



Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/player/details', [PlayerDetailController::class, 'index'])->name('admin.player.details.index');
    Route::get('/admin/player/details/create', [PlayerDetailController::class, 'create'])->name('admin.player.details.create');
    Route::post('/admin/player/details', [PlayerDetailController::class, 'store'])->name('admin.player.details.store');
    Route::get('/admin/player/{user}/details', [PlayerDetailController::class, 'edit'])->name('admin.player.details.edit');
    Route::put('/admin/player/{user}/details', [PlayerDetailController::class, 'update'])->name('admin.player.details.update');
    Route::delete('/admin/player/{user}/details', [PlayerDetailController::class, 'destroy'])->name('admin.player.details.destroy');
});
require __DIR__.'/auth.php';
