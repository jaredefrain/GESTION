@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Torneo</h1>
    <form action="{{ route('admin.tournaments.update', $tournament) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nombre del Torneo</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $tournament->name }}" required>
        </div>
        <div class="form-group">
            <label for="type">Tipo de Torneo</label>
            <select name="type" id="type" class="form-control" required>
                <option value="eliminatorias" {{ $tournament->type == 'eliminatorias' ? 'selected' : '' }}>Eliminatorias</option>
                <option value="liga" {{ $tournament->type == 'liga' ? 'selected' : '' }}>Liga</option>
                <option value="mixto" {{ $tournament->type == 'mixto' ? 'selected' : '' }}>Mixto</option>
            </select>
        </div>
        <div class="form-group">
            <label for="number_of_teams">Número de Equipos</label>
            <input type="number" name="number_of_teams" id="number_of_teams" class="form-control" value="{{ $tournament->number_of_teams }}" required>
        </div>
        <div class="form-group">
            <label for="teams">Equipos</label>
            <div id="teams" class="form-control" style="height: auto;">
                @foreach($teams as $team)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="teams[]" value="{{ $team->id }}" id="team{{ $team->id }}" {{ in_array($team->id, $tournament->teams->pluck('id')->toArray()) ? 'checked' : '' }}>
                        <label class="form-check-label" for="team{{ $team->id }}">
                            {{ $team->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="form-group">
            <label for="referees">Árbitros</label>
            <div id="referees" class="form-control" style="height: auto;">
                @foreach($referees as $referee)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="referees[]" value="{{ $referee->id }}" id="referee{{ $referee->id }}" {{ in_array($referee->id, $tournament->referees->pluck('id')->toArray()) ? 'checked' : '' }}>
                        <label class="form-check-label" for="referee{{ $referee->id }}">
                            {{ $referee->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Torneo</button>
    </form>
</div>
@endsection