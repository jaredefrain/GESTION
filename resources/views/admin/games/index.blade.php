@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Games</h1>
    <a href="{{ route('admin.games.create') }}" class="btn btn-primary">Create Game</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tournament</th>
                <th>Team 1</th>
                <th>Team 2</th>
                <th>Referee</th>
                <th>Match Date</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($games as $game)
                <tr>
                    <td>{{ $game->id }}</td>
                    <td>{{ $game->tournament->name }}</td>
                    <td>{{ $game->team1->name }}</td>
                    <td>{{ $game->team2->name }}</td>
                    <td>{{ $game->referee->name }}</td>
                    <td>{{ $game->match_date }}</td>
                    <td>{{ $game->location }}</td>
                    <td>
                        <a href="{{ route('admin.games.edit', $game) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.games.destroy', $game) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

