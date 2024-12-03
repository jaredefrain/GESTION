@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Bienvenido, {{ Auth::user()->name }}</h1>
        <p class="mb-4">Aquí puedes ver tus detalles, próximos partidos y estadísticas del torneo.</p>

<!-- Detalles del Jugador -->
<div class="mb-6">
    <h2 class="text-xl font-semibold mb-2">Detalles del Jugador</h2>
    <div class="grid grid-cols-2 gap-4">
        @if(Auth::user()->playerDetail)
            <div class="bg-gray-100 p-4 rounded-lg shadow">
                <p><strong>Altura:</strong> {{ Auth::user()->playerDetail->height }} cm</p>
                <p><strong>Posición:</strong> {{ Auth::user()->playerDetail->position }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg shadow">
                <p><strong>Goles:</strong> {{ Auth::user()->playerDetail->goals }}</p>
                <p><strong>Asistencias:</strong> {{ Auth::user()->playerDetail->assists }}</p>
            </div>
            <div class="bg-gray-100 p-4 rounded-lg shadow">
                <p><strong>Tarjetas Amarillas:</strong> {{ Auth::user()->playerDetail->yellow_cards }}</p>
                <p><strong>Tarjetas Rojas:</strong> {{ Auth::user()->playerDetail->red_cards }}</p>
            </div>
        @else
            <div class="bg-gray-100 p-4 rounded-lg shadow">
                <p>No hay detalles del jugador disponibles.</p>
            </div>
        @endif
    </div>
</div>

        <!-- Próximos Partidos -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Próximos Partidos</h2>
            <div class="flex justify-between items-center mb-4">
                <button id="toggleTableBtn" class="bg-blue-500 text-white px-4 py-2 rounded">Ocultar/Mostrar Tabla</button>
                <input type="text" id="filterInput" placeholder="Filtrar por equipo" class="border p-2 rounded">
            </div>

            <div id="gamesTableContainer">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="py-2 px-4">Fecha</th>
                            <th class="py-2 px-4">Equipo 1</th>
                            <th class="py-2 px-4">Equipo 2</th>
                            <th class="py-2 px-4">Ubicación</th>
                            <th class="py-2 px-4">Árbitro</th>
                        </tr>
                    </thead>
                    <tbody id="gamesTableBody" class="text-gray-700">
                        @foreach($upcomingGames as $game)
                        <tr class="{{ $game->match_date->isPast() ? 'bg-red-100' : 'bg-green-100' }}">
                            <td class="border px-4 py-2">{{ $game->match_date->format('d/m/Y H:i') }}</td>
                            <td class="border px-4 py-2">{{ $game->team1->name }}</td>
                            <td class="border px-4 py-2">{{ $game->team2->name }}</td>
                            <td class="border px-4 py-2">{{ $game->location }}</td>
                            <td class="border px-4 py-2">{{ $game->referee->name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Estadísticas del Torneo -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Estadísticas del Torneo</h2>
            <div class="grid grid-cols-3 gap-4">
                @foreach($tournaments as $tournament)
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <h3 class="text-lg font-bold">{{ $tournament->name }}</h3>
                    <p><strong>Tipo:</strong> {{ $tournament->type }}</p>
                    <p><strong>Número de Equipos:</strong> {{ $tournament->number_of_teams }}</p>
                    <p><strong>Equipos:</strong></p>
                    <ul class="list-disc list-inside">
                        @foreach($tournament->teams as $team)
                        <li>{{ $team->name }}</li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleTableBtn = document.getElementById('toggleTableBtn');
        const gamesTableContainer = document.getElementById('gamesTableContainer');
        const filterInput = document.getElementById('filterInput');
        const gamesTableBody = document.getElementById('gamesTableBody');

        toggleTableBtn.addEventListener('click', function() {
            gamesTableContainer.classList.toggle('hidden');
        });

        filterInput.addEventListener('input', function() {
            const filterValue = filterInput.value.toLowerCase();
            const rows = gamesTableBody.getElementsByTagName('tr');
            Array.from(rows).forEach(row => {
                const team1 = row.cells[1].textContent.toLowerCase();
                const team2 = row.cells[2].textContent.toLowerCase();
                if (team1.includes(filterValue) || team2.includes(filterValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>

@endsection
