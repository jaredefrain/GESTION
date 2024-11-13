@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Editar detalles del jugador</h1>
        <form method="POST" action="{{ route('admin.player.details.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="height" class="block text-gray-700">Estatura</label>
                <input type="number" name="height" id="height" value="{{ old('height', $playerDetail->height) }}" class="w-full p-2 border border-gray-300 rounded mt-1" min="0">
            </div>
            <div class="mb-4">
                <label for="position" class="block text-gray-700">Posición</label>
                <input type="text" name="position" id="position" value="{{ old('position', $playerDetail->position) }}" class="w-full p-2 border border-gray-300 rounded mt-1">
            </div>
            <div class="mb-4">
                <label for="goals" class="block text-gray-700">Goles</label>
                <input type="number" name="goals" id="goals" value="{{ old('goals', $playerDetail->goals) }}" class="w-full p-2 border border-gray-300 rounded mt-1" min="0">
            </div>
            <div class="mb-4">
                <label for="assists" class="block text-gray-700">Asistencias</label>
                <input type="number" name="assists" id="assists" value="{{ old('assists', $playerDetail->assists) }}" class="w-full p-2 border border-gray-300 rounded mt-1" min="0">
            </div>
            <div class="mb-4">
                <label for="yellow_cards" class="block text-gray-700">Tarjetas amarillas</label>
                <input type="number" name="yellow_cards" id="yellow_cards" value="{{ old('yellow_cards', $playerDetail->yellow_cards) }}" class="w-full p-2 border border-gray-300 rounded mt-1" min="0">
            </div>
            <div class="mb-4">
                <label for="red_cards" class="block text-gray-700">Tarjetas rojas</label>
                <input type="number" name="red_cards" id="red_cards" value="{{ old('red_cards', $playerDetail->red_cards) }}" class="w-full p-2 border border-gray-300 rounded mt-1" min="0">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Guardar</button>
        </form>
    </div>
</div>
@endsection
