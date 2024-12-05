@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Dashboard de Entrenador</h2>

        <h3 class="text-xl font-semibold mb-4">Estadísticas de Jugadores</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 border-b">Jugador</th>
                        <th class="py-2 px-4 border-b">Partidos Jugados</th>
                        <th class="py-2 px-4 border-b">Goles</th>
                        <th class="py-2 px-4 border-b">Asistencias</th>
                        <th class="py-2 px-4 border-b">Tarjetas Amarillas</th>
                        <th class="py-2 px-4 border-b">Tarjetas Rojas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($playerStats as $stat)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2">{{ $stat->player->name }}</td>
                            <td class="border px-4 py-2 text-center">{{ $stat->total_games }}</td>
                            <td class="border px-4 py-2 text-center">{{ $stat->total_goals }}</td>
                            <td class="border px-4 py-2 text-center">{{ $stat->total_assists }}</td>
                            <td class="border px-4 py-2 text-center">{{ $stat->total_yellow_cards }}</td>
                            <td class="border px-4 py-2 text-center">{{ $stat->total_red_cards }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <h3 class="text-xl font-semibold mb-4">Mejor Jugador</h3>
            @if($bestPlayer)
                <div class="p-4 bg-green-100 rounded-lg">
                    <p class="text-lg font-medium">{{ $bestPlayer->player->name }}</p>
                    <p>Goles: {{ $bestPlayer->total_goals }}</p>
                    <p>Asistencias: {{ $bestPlayer->total_assists }}</p>
                    <p>Tarjetas Amarillas: {{ $bestPlayer->total_yellow_cards }}</p>
                    <p>Tarjetas Rojas: {{ $bestPlayer->total_red_cards }}</p>
                </div>
            @else
                <p>No hay datos disponibles.</p>
            @endif
        </div>

        <div class="mt-6">
            <h3 class="text-xl font-semibold mb-4">Peor Jugador</h3>
            @if($worstPlayer)
                <div class="p-4 bg-red-100 rounded-lg">
                    <p class="text-lg font-medium">{{ $worstPlayer->player->name }}</p>
                    <p>Goles: {{ $worstPlayer->total_goals }}</p>
                    <p>Asistencias: {{ $worstPlayer->total_assists }}</p>
                    <p>Tarjetas Amarillas: {{ $worstPlayer->total_yellow_cards }}</p>
                    <p>Tarjetas Rojas: {{ $worstPlayer->total_red_cards }}</p>
                </div>
            @else
                <p>No hay datos disponibles.</p>
            @endif
        </div>

        <div class="mt-6">
            <h3 class="text-xl font-semibold mb-4">Seleccionar Jugador</h3>
            <form method="GET" action="{{ route('coach.dashboard') }}" onsubmit="return validateForm()">
                <select name="player_id" id="player_id" class="border border-gray-300 rounded p-2">
                    <option value="">Seleccione un jugador</option>
                    @foreach($players as $player)
                        <option value="{{ $player->id }}" {{ request('player_id') == $player->id ? 'selected' : '' }}>{{ $player->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded">Ver Rendimiento</button>
            </form>
            <p id="error-message" class="text-red-500 mt-2" style="display: none;">Primero debe seleccionar un jugador.</p>
        </div>

        @if($selectedPlayer && $selectedPlayerStats)
            <div class="mt-6">
                <h3 class="text-xl font-semibold mb-4">Rendimiento de {{ $selectedPlayer->name }}</h3>
                <canvas id="playerPerformanceChart"></canvas>
            </div>
        @endif
    </div>
</div>

@if($selectedPlayer && $selectedPlayerStats)
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('playerPerformanceChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Partidos Jugados', 'Goles', 'Asistencias', 'Tarjetas Amarillas', 'Tarjetas Rojas'],
                datasets: [{
                    label: 'Estadísticas',
                    data: [
                        {{ $selectedPlayerStats->total_games }},
                        {{ $selectedPlayerStats->total_goals }},
                        {{ $selectedPlayerStats->total_assists }},
                        {{ $selectedPlayerStats->total_yellow_cards }},
                        {{ $selectedPlayerStats->total_red_cards }}
                    ],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endif

<script>
function validateForm() {
    const playerSelect = document.getElementById('player_id');
    const errorMessage = document.getElementById('error-message');
    if (playerSelect.value === '') {
        errorMessage.style.display = 'block';
        return false;
    }
    errorMessage.style.display = 'none';
    return true;
}
</script>
@endsection