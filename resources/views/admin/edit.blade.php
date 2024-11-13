@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Editar Usuario</h1>
        <form method="POST" action="{{ route('admin.update', $user) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nombre</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full p-2 border border-gray-300 rounded mt-1">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full p-2 border border-gray-300 rounded mt-1">
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Contraseña (dejar en blanco para mantener la actual)</label>
                <input type="password" name="password" id="password" class="w-full p-2 border border-gray-300 rounded mt-1">
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full p-2 border border-gray-300 rounded mt-1">
            </div>
            <div class="mb-4">
                <label for="role" class="block text-gray-700">Rol</label>
                <select name="role" id="role" class="w-full p-2 border border-gray-300 rounded mt-1">
                    <option value="referee" {{ $user->role == 'referee' ? 'selected' : '' }}>Árbitro</option>
                    <option value="coach" {{ $user->role == 'coach' ? 'selected' : '' }}>Entrenador</option>
                    <option value="player" {{ $user->role == 'player' ? 'selected' : '' }}>Jugador</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="age" class="block text-gray-700">Edad</label>
                <input type="number" name="age" id="age" value="{{ old('age', $user->age) }}" class="w-full p-2 border border-gray-300 rounded mt-1">
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Guardar</button>
        </form>
    </div>
</div>
@endsection