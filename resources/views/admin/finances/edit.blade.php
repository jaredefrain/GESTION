@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Editar Registro Financiero</h1>
        <form action="{{ route('admin.finances.update', $finance) }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Tipo</label>
                <input type="text" name="type" id="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $finance->type }}" required>
            </div>
            <div class="mb-4">
                <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Monto</label>
                <input type="number" name="amount" id="amount" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $finance->amount }}" required>
            </div>
            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
                <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $finance->description }}</textarea>
            </div>
            <div class="mb-4">
                <label for="tournament_id" class="block text-gray-700 text-sm font-bold mb-2">Torneo</label>
                <select name="tournament_id" id="tournament_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Seleccionar Torneo</option>
                    @foreach($tournaments as $tournament)
                        <option value="{{ $tournament->id }}" {{ $finance->tournament_id == $tournament->id ? 'selected' : '' }}>{{ $tournament->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="team_id" class="block text-gray-700 text-sm font-bold mb-2">Equipo</label>
                <select name="team_id" id="team_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    <option value="">Seleccionar Equipo</option>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ $finance->team_id == $team->id ? 'selected' : '' }}>{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Guardar</button>
            </div>
        </form>
    </div>
@endsection