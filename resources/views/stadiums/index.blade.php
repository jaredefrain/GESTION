@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Estadios</h1>
    <a href="{{ route('stadiums.create') }}" class="btn btn-primary">Crear Estadio</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Equipo</th>
                <th>¿Tiene Evento?</th>
                <th>Inicio del Evento</th>
                <th>Fin del Evento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stadiums as $stadium)
            <tr>
                <td>{{ $stadium->name }}</td>
                <td>{{ $stadium->team->name }}</td>
                <td>{{ $stadium->has_event ? 'Sí' : 'No' }}</td>
                <td>{{ $stadium->event_start }}</td>
                <td>{{ $stadium->event_end }}</td>
                <td>
                    <a href="{{ route('stadiums.edit', $stadium) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('stadiums.destroy', $stadium) }}" method="POST" style="display:inline;">
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