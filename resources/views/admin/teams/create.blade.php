@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h1 class="h3 mb-0">Crear Equipo</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo:</label>
                            <input type="file" name="logo" id="logo" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="player-search" class="form-label">Buscar Jugadores:</label>
                            <input type="text" id="player-search" class="form-control" placeholder="Buscar por nombre...">
                        </div>
                        <div class="mb-3">
                            <label for="players" class="form-label">Jugadores:</label>
                            <div id="players-list" class="form-check">
                                @foreach ($players as $player)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="players[]" value="{{ $player->id }}" id="player-{{ $player->id }}">
                                        <label class="form-check-label" for="player-{{ $player->id }}">
                                            {{ $player->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('player-search').addEventListener('input', function() {
        let filter = this.value.toLowerCase();
        let players = document.querySelectorAll('#players-list .form-check');

        players.forEach(function(player) {
            let playerName = player.querySelector('label').textContent.toLowerCase();
            if (playerName.includes(filter)) {
                player.style.display = '';
            } else {
                player.style.display = 'none';
            }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let toggleIcon = document.createElement('span');
        toggleIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/><path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/></svg>';
        toggleIcon.style.cursor = 'pointer';
        toggleIcon.style.marginBottom = '1rem';
        document.querySelector('#players-list').before(toggleIcon);

        let playersList = document.getElementById('players-list');
        playersList.style.display = 'none';

        toggleIcon.addEventListener('click', function() {
            if (playersList.style.display === 'none') {
                playersList.style.display = '';
                toggleIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16"><path d="M13.359 11.238C12.21 12.226 10.71 13 8 13c-2.71 0-4.21-.774-5.359-1.762A13.133 13.133 0 0 1 1.172 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.71 0 4.21.774 5.359 1.762A13.133 13.133 0 0 1 14.828 8c-.329.4-.688.78-1.07 1.138l.601.6z"/><path d="M11.354 8.354a.5.5 0 0 0-.708-.708L8 10.293 5.354 7.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3z"/><path d="M3.646 3.646a.5.5 0 0 1 .708 0l8 8a.5.5 0 0 1-.708.708l-8-8a.5.5 0 0 1 0-.708z"/></svg>';
            } else {
                playersList.style.display = 'none';
                toggleIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8a13.133 13.133 0 0 1-1.66 2.043C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/><path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/></svg>';
            }
        });
    });
</script>
@endsection
