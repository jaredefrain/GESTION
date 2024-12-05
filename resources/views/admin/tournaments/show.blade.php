@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $tournament->name }}</h1>
    <p>Type: {{ $tournament->type }}</p>
    <p>Number of Teams: {{ $tournament->number_of_teams }}</p>
    <h2>Teams</h2>
    <ul>
        @foreach($tournament->teams as $team)
            <li>{{ $team->name }}</li>
        @endforeach
    </ul>
    <h2>Referees</h2>
    <ul>
        @foreach($tournament->referees as $referee)
            <li>{{ $referee->name }}</li>
        @endforeach
    </ul>
    <a href="{{ route('admin.tournaments.edit', $tournament) }}" class="btn btn-warning">Edit</a>
    <form action="{{ route('admin.tournaments.destroy', $tournament) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    <a href="{{ route('admin.tournaments.generateFixtures', $tournament) }}" class="btn btn-primary">Generate Fixtures</a>
</div>
@endsection
