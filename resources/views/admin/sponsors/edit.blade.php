@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Editar Patrocinador</h1>
        <form action="{{ route('admin.sponsors.update', $sponsor) }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre</label>
                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $sponsor->name }}" required>
            </div>
            <div class="mb-4">
                <label for="logo" class="block text-gray-700 text-sm font-bold mb-2">Logo</label>
                <input type="file" name="logo" id="logo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @if($sponsor->logo)
                    <img src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }}" width="100" class="mt-2">
                @endif
            </div>
            <div class="mb-4">
                <label for="website" class="block text-gray-700 text-sm font-bold mb-2">Sitio Web</label>
                <input type="url" name="website" id="website" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $sponsor->website }}">
            </div>
            <div class="mb-4">
                <label for="tournaments" class="block text-gray-700 text-sm font-bold mb-2">Torneos</label>
                <select name="tournaments[]" id="tournaments" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" multiple>
                    @foreach($tournaments as $tournament)
                        <option value="{{ $tournament->id }}" {{ in_array($tournament->id, $sponsor->tournaments->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $tournament->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label for="teams" class="block text-gray-700 text-sm font-bold mb-2">Equipos</label>
                <select name="teams[]" id="teams" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" multiple>
                    @foreach($teams as $team)
                        <option value="{{ $team->id }}" {{ in_array($team->id, $sponsor->teams->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Guardar</button>
            </div>
        </form>
    </div>
@endsection