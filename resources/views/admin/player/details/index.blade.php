@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Detalles de los Jugadores</h1>
        <div class="mb-4">
            <a href="{{ route('admin.player.details.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Añadir Detalles a Jugador</a>
        </div>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-2">Nombre</th>
                    <th class="py-2">Estatura</th>
                    <th class="py-2">Posición</th>
                    <th class="py-2">Goles</th>
                    <th class="py-2">Asistencias</th>
                    <th class="py-2">Tarjetas Amarillas</th>
                    <th class="py-2">Tarjetas Rojas</th>
                    <th class="py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($playerDetails as $detail)
                    <tr>
                        <td class="py-2">{{ $detail->user->name }}</td>
                        <td class="py-2">{{ $detail->height }}</td>
                        <td class="py-2">{{ $detail->position }}</td>
                        <td class="py-2">{{ $detail->goals }}</td>
                        <td class="py-2">{{ $detail->assists }}</td>
                        <td class="py-2">{{ $detail->yellow_cards }}</td>
                        <td class="py-2">{{ $detail->red_cards }}</td>
                        <td class="py-2">
                            <a href="{{ route('admin.player.details.edit', $detail->user) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Editar</a>
                            <form action="{{ route('admin.player.details.destroy', $detail->user) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
