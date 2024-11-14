
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
            <label for="number_of_teams">Numero de equipos</label>
            <input type="number" name="number_of_teams" id="number_of_teams" class="form-control" value="{{ $tournament->number_of_teams }}" required>
        </div>
        <div class="form-group">
            <label for="teams">Equipos</label>
            <select name="teams[]" id="teams" class="form-control" multiple required>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}" {{ in_array($team->id, $tournament->teams->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $team->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="referees">Arbitros</label>
            <select name="referees[]" id="referees" class="form-control" multiple required>
                @foreach($referees as $referee)
                    <option value="{{ $referee->id }}" {{ in_array($referee->id, $tournament->referees->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $referee->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Torneo</button>
    </form>
</div>
@endsection