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
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\StadiumController;
use App\Http\Controllers\SponsorController;
use App\Http\Controllers\FinanceController;

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

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/tournaments', [TournamentController::class, 'index'])->name('admin.tournaments.index');
    Route::get('/admin/tournaments/create', [TournamentController::class, 'create'])->name('admin.tournaments.create');
    Route::post('/admin/tournaments', [TournamentController::class, 'store'])->name('admin.tournaments.store');
    Route::get('/admin/tournaments/{tournament}/edit', [TournamentController::class, 'edit'])->name('admin.tournaments.edit');
    Route::put('/admin/tournaments/{tournament}', [TournamentController::class, 'update'])->name('admin.tournaments.update');
    Route::get('/admin/tournaments/{tournament}', [TournamentController::class, 'show'])->name('admin.tournaments.show');
    Route::delete('/admin/tournaments/{tournament}', [TournamentController::class, 'destroy'])->name('admin.tournaments.destroy');
    Route::get('/admin/tournaments/{tournament}/generateFixtures', [TournamentController::class, 'generateFixtures'])->name('admin.tournaments.generateFixtures');
});

// Rutas para la gestión de vistas de juegos por el admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/games', [GameController::class, 'index'])->name('admin.games.index'); // Vista para listar todos los juegos
    Route::get('/admin/games/create', [GameController::class, 'create'])->name('admin.games.create'); // Vista para crear un nuevo juego
    Route::post('/admin/games', [GameController::class, 'store'])->name('admin.games.store'); // Acción para almacenar un nuevo juego
    Route::get('/admin/games/{game}/edit', [GameController::class, 'edit'])->name('admin.games.edit'); // Vista para editar un juego existente
    Route::put('/admin/games/{game}', [GameController::class, 'update'])->name('admin.games.update'); // Acción para actualizar un juego existente
    Route::delete('/admin/games/{game}', [GameController::class, 'destroy'])->name('admin.games.destroy'); // Acción para eliminar un juego existente
    Route::get('admin/games/events', [GameController::class, 'events'])->name('admin.games.events');
    Route::get('/admin/games/{game}/manage', [GameController::class, 'manage'])->name('admin.games.manage');
    Route::post('/admin/games/{game}/statistics', [GameController::class, 'storeStatistics'])->name('admin.games.statistics.store');
    Route::post('teams/{team}/assign-coach', [TeamController::class, 'assignCoach'])->name('teams.assignCoach');
    Route::get('/stadiums', [StadiumController::class, 'index'])->name('stadiums.index');
    Route::get('/stadiums/create', [StadiumController::class, 'create'])->name('stadiums.create');
    Route::post('/stadiums', [StadiumController::class, 'store'])->name('stadiums.store');
    Route::get('/stadiums/{stadium}/edit', [StadiumController::class, 'edit'])->name('stadiums.edit');
    Route::put('/stadiums/{stadium}', [StadiumController::class, 'update'])->name('stadiums.update');
    Route::delete('/stadiums/{stadium}', [StadiumController::class, 'destroy'])->name('stadiums.destroy');
});

// Rutas para la gestión de patrocinadores por el admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/sponsors', [SponsorController::class, 'index'])->name('admin.sponsors.index');
    Route::get('/admin/sponsors/create', [SponsorController::class, 'create'])->name('admin.sponsors.create');
    Route::post('/admin/sponsors', [SponsorController::class, 'store'])->name('admin.sponsors.store');
    Route::get('/admin/sponsors/{sponsor}/edit', [SponsorController::class, 'edit'])->name('admin.sponsors.edit');
    Route::put('/admin/sponsors/{sponsor}', [SponsorController::class, 'update'])->name('admin.sponsors.update');
    Route::delete('/admin/sponsors/{sponsor}', [SponsorController::class, 'destroy'])->name('admin.sponsors.destroy');
});

// Rutas para la gestión financiera por el admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/finances', [FinanceController::class, 'index'])->name('admin.finances.index');
    Route::get('/admin/finances/create', [FinanceController::class, 'create'])->name('admin.finances.create');
    Route::post('/admin/finances', [FinanceController::class, 'store'])->name('admin.finances.store');
    Route::get('/admin/finances/{finance}/edit', [FinanceController::class, 'edit'])->name('admin.finances.edit');
    Route::put('/admin/finances/{finance}', [FinanceController::class, 'update'])->name('admin.finances.update');
    Route::delete('/admin/finances/{finance}', [FinanceController::class, 'destroy'])->name('admin.finances.destroy');
});

Route::get('/league/standings/{tournamentId}', [LeagueController::class, 'standings'])->name('league.standings');
Route::get('/', [LeagueController::class, 'index'])->name('welcome');
Route::get('/league/games/{tournamentId}', [GameController::class, 'getGamesByTournament'])->name('league.games');
Route::get('/', [LeagueController::class, 'index'])->name('welcome');

require __DIR__.'/auth.php';

Route::get('/league/standings', [LeagueController::class, 'standings'])->name('league.standings');