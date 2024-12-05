@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Partido</h1>
    <form action="{{ route('admin.games.update', $game) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="tournament_id" class="form-label">Torneo</label>
            <select name="tournament_id" id="tournament_id" class="form-control">
                @foreach($tournaments as $tournament)
                    <option value="{{ $tournament->id }}" {{ $game->tournament_id == $tournament->id ? 'selected' : '' }}>{{ $tournament->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="team1_id" class="form-label">Equipo 1</label>
            <select name="team1_id" id="team1_id" class="form-control">
                @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ $game->team1_id == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="team2_id" class="form-label">Equipo 2</label>
            <select name="team2_id" id="team2_id" class="form-control">
                @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ $game->team2_id == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="referee_id" class="form-label">Árbitro</label>
            <select name="referee_id" id="referee_id" class="form-control">
                @foreach($referees as $referee)
                    <option value="{{ $referee->id }}" {{ $game->referee_id == $referee->id ? 'selected' : '' }}>{{ $referee->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="match_date" class="form-label">Fecha del Partido</label>
            <input type="datetime-local" name="match_date" id="match_date" class="form-control" value="{{ \Carbon\Carbon::parse($game->match_date)->format('Y-m-d\TH:i') }}">
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Ubicación</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ $game->location }}">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection