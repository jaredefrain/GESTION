@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Gestionar Partido</h1>
        <p class="mb-4">Aquí puedes gestionar los detalles del partido.</p>

        <!-- Detalles del Partido -->
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-gray-100 p-4 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-2">Detalles del Partido</h2>
                <p><strong>Equipo 1:</strong> {{ $game->team1->name }}</p>
                <p><strong>Equipo 2:</strong> {{ $game->team2->name }}</p>
                <p><strong>Fecha:</strong> {{ $game->match_date->format('d/m/Y H:i') }}</p>
                <p><strong>Ubicación:</strong> {{ $game->location }}</p>
                <p><strong>Árbitro:</strong> {{ $game->referee->name }}</p>
            </div>

            <!-- Resultado del Partido -->
            <div class="bg-gray-100 p-4 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-2 text-center">Resultado del Partido</h2>
                <div class="flex items-center justify-between mb-4">
                    <div class="text-center">
                        <img src="{{('/storage/' . $game->team1->logo) }}" alt="{{ $game->team1->name }}" class="w-16 h-16 mx-auto">
                        <p class="font-bold">{{ $game->team1->name }}</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold">{{ $team1Goals }} <span class="mx-2">-</span> {{ $team2Goals }}</p>
                    </div>
                    <div class="text-center">
                        <img src="{{('/storage/' . $game->team2->logo) }}" alt="{{ $game->team2->name }}" class="w-16 h-16 mx-auto">
                        <p class="font-bold">{{ $game->team2->name }}</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Goles y Asistencias</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-bold">{{ $game->team1->name }}</h4>
                            <ul class="list-disc list-inside">
                                @foreach($statistics->where('team_id', $game->team1->id) as $stat)
                                    @if($stat->goals > 0)
                                        <li>{{ $stat->player->name }}: {{ $stat->goals }} goles</li>
                                    @endif
                                    @if($stat->assists > 0)
                                        <li>{{ $stat->player->name }}: {{ $stat->assists }} asistencias</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-bold">{{ $game->team2->name }}</h4>
                            <ul class="list-disc list-inside">
                                @foreach($statistics->where('team_id', $game->team2->id) as $stat)
                                    @if($stat->goals > 0)
                                        <li>{{ $stat->player->name }}: {{ $stat->goals }} goles</li>
                                    @endif
                                    @if($stat->assists > 0)
                                        <li>{{ $stat->player->name }}: {{ $stat->assists }} asistencias</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón para Abrir el Modal -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Añadir Estadísticas del Partido</h2>
            <button id="openModalBtn" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Añadir Estadísticas</button>
        </div>

        <!-- Modal -->
        <div id="modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Añadir Estadísticas del Partido</h3>
                                <div class="mt-2">
                                    <form id="statisticsForm" action="{{ route('admin.games.statistics.store', $game->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-4">
                                            <label for="team_id" class="block text-gray-700 font-bold mb-2">Equipo</label>
                                            <select name="team_id" id="team_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                                <option value="{{ $game->team1->id }}">{{ $game->team1->name }}</option>
                                                <option value="{{ $game->team2->id }}">{{ $game->team2->name }}</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="player_id" class="block text-gray-700 font-bold mb-2">Jugador</label>
                                            <select name="player_id" id="player_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                                @foreach($players as $player)
                                                    <option value="{{ $player->id }}" data-team="{{ $player->teams->first()->id }}">{{ $player->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="goals" class="block text-gray-700 font-bold mb-2">Goles</label>
                                            <input type="number" name="goals" id="goals" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="assists" class="block text-gray-700 font-bold mb-2">Asistencias</label>
                                            <input type="number" name="assists" id="assists" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="yellow_cards" class="block text-gray-700 font-bold mb-2">Tarjetas Amarillas</label>
                                            <input type="number" name="yellow_cards" id="yellow_cards" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="red_cards" class="block text-gray-700 font-bold mb-2">Tarjetas Rojas</label>
                                            <input type="number" name="red_cards" id="red_cards" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="incidents" class="block text-gray-700 font-bold mb-2">Incidentes</label>
                                            <textarea name="incidents" id="incidents" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                                        </div>
                                        <div class="sm:flex sm:items-center sm:justify-between">
                                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Añadir Estadísticas</button>
                                            <button type="button" id="closeModalBtn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">Cancelar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas del Partido -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Estadísticas del Partido</h2>
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4">Equipo</th>
                        <th class="py-2 px-4">Jugador</th>
                        <th class="py-2 px-4">Goles</th>
                        <th class="py-2 px-4">Asistencias</th>
                        <th class="py-2 px-4">Tarjetas Amarillas</th>
                        <th class="py-2 px-4">Tarjetas Rojas</th>
                        <th class="py-2 px-4">Incidentes</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($statistics as $stat)
                    <tr>
                        <td class="border px-4 py-2">{{ $stat->team->name }}</td>
                        <td class="border px-4 py-2">{{ $stat->player->name }}</td>
                        <td class="border px-4 py-2">{{ $stat->goals }}</td>
                        <td class="border px-4 py-2">{{ $stat->assists }}</td>
                        <td class="border px-4 py-2">{{ $stat->yellow_cards }}</td>
                        <td class="border px-4 py-2">{{ $stat->red_cards }}</td>
                        <td class="border px-4 py-2">{{ $stat->incidents }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Gráficas del Partido -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Gráficas del Partido</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <canvas id="goalsChart"></canvas>
                </div>
                <div>
                    <canvas id="cardsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const openModalBtn = document.getElementById('openModalBtn');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const modal = document.getElementById('modal');

        openModalBtn.addEventListener('click', function() {
            modal.classList.remove('hidden');
        });

        closeModalBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
        });

        // Datos para las gráficas
        const statistics = @json($statistics);
        const teams = [
            { id: {{ $game->team1->id }}, name: "{{ $game->team1->name }}" },
            { id: {{ $game->team2->id }}, name: "{{ $game->team2->name }}" }
        ];

        // Preparar datos para la gráfica de goles
        const goalsData = {
            labels: teams.map(team => team.name),
            datasets: [{
                label: 'Goles',
                data: teams.map(team => statistics.filter(stat => stat.team_id === team.id).reduce((sum, stat) => sum + stat.goals, 0)),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        // Preparar datos para la gráfica de tarjetas
        const cardsData = {
            labels: teams.map(team => team.name),
            datasets: [{
                label: 'Tarjetas Amarillas',
                data: teams.map(team => statistics.filter(stat => stat.team_id === team.id).reduce((sum, stat) => sum + stat.yellow_cards, 0)),
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            }, {
                label: 'Tarjetas Rojas',
                data: teams.map(team => statistics.filter(stat => stat.team_id === team.id).reduce((sum, stat) => sum + stat.red_cards, 0)),
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const teamSelect = document.getElementById('team_id');
        const playerSelect = document.getElementById('player_id');
        const players = Array.from(playerSelect.options);

        teamSelect.addEventListener('change', function() {
            const selectedTeam = this.value;
            playerSelect.innerHTML = '';

            players.forEach(player => {
                if (player.getAttribute('data-team') === selectedTeam) {
                    playerSelect.appendChild(player);
                }
            });
        });

        // Trigger change event to initialize the player select options
        teamSelect.dispatchEvent(new Event('change'));
    });
</script>
@endsection