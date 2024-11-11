@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Editar Equipo</h1>
        <form action="{{ route('teams.update', $team) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nombre:</label>
                <input type="text" name="name" id="name" value="{{ $team->name }}" class="w-full border-gray-300 rounded-lg shadow-sm" required>
            </div>
            <div class="mb-4">
                <label for="logo" class="block text-gray-700">Logo:</label>
                <input type="file" name="logo" id="logo" class="w-full border-gray-300 rounded-lg shadow-sm">
                @if ($team->logo)
                    <img src="{{ Storage::url($team->logo) }}" alt="{{ $team->name }}" class="w-16 h-16 mt-2">
                @endif
            </div>
            <div class="mb-4">
                <label for="players" class="block text-gray-700">Jugadores:</label>
                <select name="players[]" id="players" class="w-full border-gray-300 rounded-lg shadow-sm" multiple>
                    @foreach ($players as $player)
                        <option value="{{ $player->id }}" {{ in_array($player->id, $team->players->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $player->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Actualizar</button>
        </form>
    </div>
</div>
@endsection