<!-- resources/views/league/standings.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tabla de Posiciones</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Equipo</th>
                <th>PTS</th>
                <th>PJ</th>
                <th>G</th>
                <th>P</th>
                <th>D</th>
                <th>GF</th>
                <th>GC</th>
                <th>DG</th>
            </tr>
        </thead>
        <tbody>
            @foreach($standings as $team)
            <tr>
                <td>{{ $team->team_name }}</td>
                <td>{{ $team->PTS }}</td>
                <td>{{ $team->PJ }}</td>
                <td>{{ $team->G }}</td>
                <td>{{ $team->P }}</td>
                <td>{{ $team->D }}</td>
                <td>{{ $team->GF }}</td>
                <td>{{ $team->GC }}</td>
                <td>{{ $team->DG }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
