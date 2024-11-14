
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Torneos</h1>
    <a href="{{ route('admin.tournaments.create') }}" class="btn btn-primary">Crear Torneos</a>
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Numero de equipos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tournaments as $tournament)
                <tr>
                    <td>{{ $tournament->name }}</td>
                    <td>{{ $tournament->type }}</td>
                    <td>{{ $tournament->number_of_teams }}</td>
                    <td>
                        <a href="{{ route('admin.tournaments.show', $tournament) }}" class="btn btn-info">Ver</a>
                        <a href="{{ route('admin.tournaments.edit', $tournament) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('admin.tournaments.destroy', $tournament) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
