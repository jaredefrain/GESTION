@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Partido</h1>
    <form action="{{ route('admin.games.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="tournament_id" class="form-label">Torneo</label>
            <select name="tournament_id" id="tournament_id" class="form-control">
                @foreach($tournaments as $tournament)
                    <option value="{{ $tournament->id }}">{{ $tournament->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="team1_id" class="form-label">Equipo 1</label>
            <select name="team1_id" id="team1_id" class="form-control">
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="team2_id" class="form-label">Equipo 2</label>
            <select name="team2_id" id="team2_id" class="form-control">
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="referee_id" class="form-label">Árbitro</label>
            <select name="referee_id" id="referee_id" class="form-control">
                @foreach($referees as $referee)
                    <option value="{{ $referee->id }}">{{ $referee->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="match_date" class="form-label">Fecha del Partido</label>
            <input type="datetime-local" name="match_date" id="match_date" class="form-control">
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Ubicación</label>
            <input type="text" name="location" id="location" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Crear</button>
    </form>
</div>
@endsection
