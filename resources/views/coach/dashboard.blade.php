@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Dashboard de Entrenador</h2>

        <!-- Información del Equipo -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-2">Equipo: {{ $team->name }}</h3>
            <img src="{{ asset('storage/' . $team->logo) }}" alt="{{ $team->name }}" class="w-24 h-24">
        </div>

        <!-- Partidos Jugados y Por Jugar -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-2">Partidos</h3>
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4">Fecha</th>
                        <th class="py-2 px-4">Equipo 1</th>
                        <th class="py-2 px-4">Equipo 2</th>
                        <th class="py-2 px-4">Ubicación</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($games as $game)
                    <tr>
                        <td class="border px-4 py-2">{{ $game->match_date->format('d/m/Y H:i') }}</td>
                        <td class="border px-4 py-2">{{ $game->team1->name }}</td>
                        <td class="border px-4 py-2">{{ $game->team2->name }}</td>
                        <td class="border px-4 py-2">{{ $game->location }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Gráficas de Estadísticas -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-2">Estadísticas del Equipo</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <canvas id="goalsChart"></canvas>
                </div>
                <div>
                    <canvas id="cardsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Estadísticas de Jugadores -->
        <div class="mb-6">
            <h3 class="text-xl font-semibold mb-2">Estadísticas de Jugadores</h3>
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4">Jugador</th>
                        <th class="py-2 px-4">Goles</th>
                        <th class="py-2 px-4">Asistencias</th>
                        <th class="py-2 px-4">Tarjetas Amarillas</th>
                        <th class="py-2 px-4">Tarjetas Rojas</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($players as $player)
                    <tr>
                        <td class="border px-4 py-2">{{ $player->name }}</td>
                        <td class="border px-4 py-2">{{ $player->playerDetail->goals }}</td>
                        <td class="border px-4 py-2">{{ $player->playerDetail->assists }}</td>
                        <td class="border px-4 py-2">{{ $player->playerDetail->yellow_cards }}</td>
                        <td class="border px-4 py-2">{{ $player->playerDetail->red_cards }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Datos para las gráficas
        const players = @json($players);
        const goalsData = {
            labels: players.map(player => player.name),
            datasets: [{
                label: 'Goles',
                data: players.map(player => player.playerDetail.goals),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        const cardsData = {
            labels: players.map(player => player.name),
            datasets: [{
                label: 'Tarjetas Amarillas',
                data: players.map(player => player.playerDetail.yellow_cards),
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }, {
                label: 'Tarjetas Rojas',
                data: players.map(player => player.playerDetail.red_cards),
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        };

        // Crear la gráfica de goles
        const goalsChartCtx = document.getElementById('goalsChart').getContext('2d');
        new Chart(goalsChartCtx, {
            type: 'bar',
            data: goalsData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Crear la gráfica de tarjetas
        const cardsChartCtx = document.getElementById('cardsChart').getContext('2d');
        new Chart(cardsChartCtx, {
            type: 'bar',
            data: cardsData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
</script>
@endsection