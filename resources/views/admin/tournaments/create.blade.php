@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Tournament</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.tournaments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Tournament Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="type">Tournament Type</label>
            <select name="type" id="type" class="form-control" required>
                <option value="eliminatorias">Eliminatorias</option>
                <option value="liga">Liga</option>
                <option value="mixto">Mixto</option>
            </select>
        </div>
        <div class="form-group">
            <label for="number_of_teams">Number of Teams</label>
            <input type="number" name="number_of_teams" id="number_of_teams" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="teams">Teams</label>
            <select name="teams[]" id="teams" class="form-control" multiple required>
                @foreach($teams as $team)
                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="referees">Referees</label>
            <select name="referees[]" id="referees" class="form-control" multiple required>
                @foreach($referees as $referee)
                    <option value="{{ $referee->id }}">{{ $referee->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Tournament</button>
    </form>
</div>
@endsection