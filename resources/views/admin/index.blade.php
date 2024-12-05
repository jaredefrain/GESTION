@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Bienvenido, Admin</h1>

        <h2 class="text-xl font-bold mb-4">Administradores</h2>
        <div id="admins-toggle" class="mb-4 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-eye toggle-icon" viewBox="2 1 22 22">
                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/>
                <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
            </svg>
        </div>
        <table id="admins-list" class="min-w-full bg-white mb-6">
            <thead>
                <tr>
                    <th class="py-2">Nombre</th>
                    <th class="py-2">Email</th>
                    <th class="py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($admins as $admin)
                    <tr>
                        <td class="py-2">{{ $admin->name }}</td>
                        <td class="py-2">{{ $admin->email }}</td>
                        <td class="py-2">
                            <a href="{{ route('admin.edit', $admin) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Editar</a>
                            <form action="{{ route('admin.destroy', $admin) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2 class="text-xl font-bold mb-4">Árbitros</h2>
        <div id="referees-toggle" class="mb-4 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-eye toggle-icon" viewBox="2 1 22 22">
                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/>
                <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
            </svg>
        </div>
        <table id="referees-list" class="min-w-full bg-white mb-6">
            <thead>
                <tr>
                    <th class="py-2">Nombre</th>
                    <th class="py-2">Email</th>
                    <th class="py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($referees as $referee)
                    <tr>
                        <td class="py-2">{{ $referee->name }}</td>
                        <td class="py-2">{{ $referee->email }}</td>
                        <td class="py-2">
                            <a href="{{ route('admin.edit', $referee) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Editar</a>
                            <form action="{{ route('admin.destroy', $referee) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2 class="text-xl font-bold mb-4">Entrenadores</h2>
        <div id="coaches-toggle" class="mb-4 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-eye toggle-icon" viewBox="2 1 22 22">
                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/>
                <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
            </svg>
        </div>
        <table id="coaches-list" class="min-w-full bg-white mb-6">
            <thead>
                <tr>
                    <th class="py-2">Nombre</th>
                    <th class="py-2">Email</th>
                    <th class="py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($coaches as $coach)
                    <tr>
                        <td class="py-2">{{ $coach->name }}</td>
                        <td class="py-2">{{ $coach->email }}</td>
                        <td class="py-2">
                            <a href="{{ route('admin.edit', $coach) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Editar</a>
                            <form action="{{ route('admin.destroy', $coach) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2 class="text-xl font-bold mb-4">Jugadores</h2>
        <div id="players-toggle" class="mb-4 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-eye toggle-icon" viewBox="2 1 22 22">
                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/>
                <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
            </svg>
        </div>
        <table id="players-list" class="min-w-full bg-white mb-6">
            <thead>
                <tr>
                    <th class="py-2">Nombre</th>
                    <th class="py-2">Email</th>
                    <th class="py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($players as $player)
                    <tr>
                        <td class="py-2">{{ $player->name }}</td>
                        <td class="py-2">{{ $player->email }}</td>
                        <td class="py-2">
                            <a href="{{ route('admin.edit', $player) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Editar</a>
                            <form action="{{ route('admin.destroy', $player) }}" method="POST" class="inline-block">
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

<style>
    .toggle-icon {
        width: 24px;
        height: 24px;
        cursor: pointer;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sections = ['admins', 'referees', 'coaches', 'players'];

        sections.forEach(section => {
            let toggleIcon = document.querySelector(`#${section}-toggle svg`);
            let list = document.getElementById(`${section}-list`);
            list.style.display = 'none';

            toggleIcon.addEventListener('click', function() {
                if (list.style.display === 'none') {
                    list.style.display = '';
                    toggleIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-eye-slash toggle-icon" viewBox="0 0 16 16"><path d="M13.359 11.238C12.21 12.226 10.71 13 8 13c-2.71 0-4.21-.774-5.359-1.762A13.133 13.133 0 0 1 1.172 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.71 0 4.21.774 5.359 1.762A13.133 13.133 0 0 1 14.828 8c-.329.4-.688.78-1.07 1.138l.601.6z"/><path d="M11.354 8.354a.5.5 0 0 0-.708-.708L8 10.293 5.354 7.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3z"/><path d="M3.646 3.646a.5.5 0 0 1 .708 0l8 8a.5.5 0 0 1-.708.708l-8-8a.5.5 0 0 1 0-.708z"/></svg>';
                } else {
                    list.style.display = 'none';
                    toggleIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-eye toggle-icon" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/><path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/></svg>';
                }
            });
        });
    });
</script>
@endsection