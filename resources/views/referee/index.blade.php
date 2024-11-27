@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Bienvenido, {{ Auth::user()->name }}</h1>
        <p class="mb-4">Aquí puedes ver tus detalles, partidos que has pitado y estadísticas de los partidos.</p>

        <!-- Estadísticas del Árbitro -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Estadísticas del Árbitro</h2>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p><strong>Total de Partidos Pitados:</strong> {{ $totalGames }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p><strong>Total de Equipos:</strong> {{ $totalTeams }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <p><strong>Total de Torneos:</strong> {{ $totalTournaments }}</p>
                </div>
            </div>
        </div>

        <!-- Partidos Pitados -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Partidos Pitados</h2>
            <div class="mb-6">
                <h2 class="text-xl font-semibold mb-2">Filtrar Partidos</h2>
                <form id="filterForm" class="mb-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="teamFilter" class="block text-sm font-medium text-gray-700">Equipo</label>
                            <input type="text" id="teamFilter" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="locationFilter" class="block text-sm font-medium text-gray-700">Ubicación</label>
                            <input type="text" id="locationFilter" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Filtrar</button>
                    </div>
                </form>
            </div>
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4">Fecha</th>
                        <th class="py-2 px-4">Equipo 1</th>
                        <th class="py-2 px-4">Equipo 2</th>
                        <th class="py-2 px-4">Ubicación</th>
                        <th class="py-2 px-4">Torneo</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($refereedGames as $game)
                    <tr class="{{ $game->match_date->isPast() ? 'bg-red-100' : 'bg-green-100' }}">
                        <td class="border px-4 py-2">{{ $game->match_date->format('d/m/Y H:i') }}</td>
                        <td class="border px-4 py-2">{{ $game->team1->name }}</td>
                        <td class="border px-4 py-2">{{ $game->team2->name }}</td>
                        <td class="border px-4 py-2">{{ $game->location }}</td>
                        <td class="border px-4 py-2">{{ $game->tournament->name }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filterForm = document.getElementById('filterForm');
        const teamFilter = document.getElementById('teamFilter');
        const locationFilter = document.getElementById('locationFilter');

        filterForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const team = teamFilter.value.toLowerCase();
            const location = locationFilter.value.toLowerCase();

            document.querySelectorAll('tbody tr').forEach(function (row) {
                const team1 = row.children[1].textContent.toLowerCase();
                const team2 = row.children[2].textContent.toLowerCase();
                const rowLocation = row.children[3].textContent.toLowerCase();

                if ((team && (team1.includes(team) || team2.includes(team))) || (location && rowLocation.includes(location)) || (!team && !location)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>

@endsection