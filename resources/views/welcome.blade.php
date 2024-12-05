<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Sistema de Gestión Deportiva</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

        <style>
            /* Estilos personalizados adicionales */
            .hero-bg {
                background-image: url('https://www.hospitalbackgroundimage.com'); /* Añade la URL de una imagen de fondo relevante */
                background-size: cover;
                background-position: center;
            }

            #standings-section, #games-section {
                margin-top: 0;
                padding-top: 0;
                transition: all 0.3s ease-in-out;
            }
        </style>
    </head>
    <body class="font-sans antialiased dark:bg-gray-900 dark:text-white">

        <!-- Sección Hero -->
        <div class="hero-bg min-h-screen flex items-center justify-center py-20">
            <div class="bg-white bg-opacity-80 rounded-lg p-10 shadow-lg text-center">
                <h1 class="text-4xl font-bold text-blue-900">Bienvenido al Sistema de Gestión Deportivo</h1>
                <p class="mt-4 text-lg text-gray-700">Gestione los registros de jugadores, partidos y la información de manera eficiente.</p>

                @if (Route::has('login'))
                    <div class="mt-8 flex justify-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Iniciar sesión</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Registrarse</a>
                            @endif
                        @endauth
                        <button id="toggle-standings" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Ver Tabla de Posiciones</button>
                        <button id="toggle-games" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Ver Calendarización de Partidos</button>
                    </div>
                @endif

                <!-- Tabla de Posiciones -->
                <div id="standings-section" class="hidden mt-4">
                    <select id="tournament-select-standings" class="bg-gray-200 text-gray-700 px-4 py-2 rounded mb-4">
                        <option value="">Seleccione un Torneo</option>
                        @foreach($tournaments as $tournament)
                            <option value="{{ $tournament->id }}">{{ $tournament->name }}</option>
                        @endforeach
                    </select>
                    <h1 class="text-2xl font-bold mb-4 text-gray-800 text-center">Tabla de Posiciones</h1>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b">Equipo</th>
                                    <th class="py-2 px-4 border-b">PTS</th>
                                    <th class="py-2 px-4 border-b">PJ</th>
                                    <th class="py-2 px-4 border-b">G</th>
                                    <th class="py-2 px-4 border-b">P</th>
                                    <th class="py-2 px-4 border-b">D</th>
                                    <th class="py-2 px-4 border-b">GF</th>
                                    <th class="py-2 px-4 border-b">GC</th>
                                    <th class="py-2 px-4 border-b">DG</th>
                                </tr>
                            </thead>
                            <tbody id="standings-body">
                                <!-- Los datos de la tabla de posiciones se cargarán aquí -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Calendarización de Partidos -->
                <div id="games-section" class="hidden mt-4">
                    <select id="tournament-select-games" class="bg-gray-200 text-gray-700 px-4 py-2 rounded mb-4">
                        <option value="">Seleccione un Torneo</option>
                        @foreach($tournaments as $tournament)
                            <option value="{{ $tournament->id }}">{{ $tournament->name }}</option>
                        @endforeach
                    </select>
                    <h1 class="text-2xl font-bold mb-4 text-gray-800 text-center">Calendarización de Partidos</h1>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-2 px-4 border-b">Fecha</th>
                                    <th class="py-2 px-4 border-b">Equipo 1</th>
                                    <th class="py-2 px-4 border-b">Equipo 2</th>
                                    <th class="py-2 px-4 border-b">Ubicación</th>
                                    <th class="py-2 px-4 border-b">Árbitro</th>
                                </tr>
                            </thead>
                            <tbody id="games-body">
                                <!-- Los datos de los partidos se cargarán aquí -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-blue-900 text-white py-6 mt-10">
            <div class="container mx-auto text-center">
                <p>&copy; 2024 Sistema de control deportivo.</p>
            </div>
        </footer>

        <script>
            document.getElementById('toggle-standings').addEventListener('click', function() {
                const standingsSection = document.getElementById('standings-section');
                const gamesSection = document.getElementById('games-section');
                if (standingsSection.classList.contains('hidden')) {
                    standingsSection.classList.remove('hidden');
                    gamesSection.classList.add('hidden');
                    this.textContent = 'Ocultar Tabla de Posiciones';
                    const tournamentSelect = document.getElementById('tournament-select-standings');
                    const tournamentId = tournamentSelect.value;
                    if (tournamentId) {
                        loadStandings(tournamentId);
                    }
                } else {
                    standingsSection.classList.add('hidden');
                    this.textContent = 'Ver Tabla de Posiciones';
                }
            });

            document.getElementById('toggle-games').addEventListener('click', function() {
                const gamesSection = document.getElementById('games-section');
                const standingsSection = document.getElementById('standings-section');
                if (gamesSection.classList.contains('hidden')) {
                    gamesSection.classList.remove('hidden');
                    standingsSection.classList.add('hidden');
                    this.textContent = 'Ocultar Calendarización de Partidos';
                    const tournamentSelect = document.getElementById('tournament-select-games');
                    const tournamentId = tournamentSelect.value;
                    if (tournamentId) {
                        loadGames(tournamentId);
                    }
                } else {
                    gamesSection.classList.add('hidden');
                    this.textContent = 'Ver Calendarización de Partidos';
                }
            });

            document.getElementById('tournament-select-standings').addEventListener('change', function() {
                const tournamentId = this.value;
                if (tournamentId) {
                    loadStandings(tournamentId);
                }
            });

            document.getElementById('tournament-select-games').addEventListener('change', function() {
                const tournamentId = this.value;
                if (tournamentId) {
                    loadGames(tournamentId);
                }
            });

            function loadStandings(tournamentId) {
                fetch(`/league/standings/${tournamentId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); // Añade esta línea para verificar la respuesta de la API
                        const standingsBody = document.getElementById('standings-body');
                        standingsBody.innerHTML = '';
                        const standingsArray = Array.isArray(data.standings) ? data.standings : Object.values(data.standings);
                        standingsArray.sort((a, b) => b.PTS - a.PTS); // Ordenar por PTS de mayor a menor
                        standingsArray.forEach(team => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td class="border px-4 py-2">${team.team_name}</td>
                                <td class="border px-4 py-2 text-center">${team.PTS}</td>
                                <td class="border px-4 py-2 text-center">${team.PJ}</td>
                                <td class="border px-4 py-2 text-center">${team.G}</td>
                                <td class="border px-4 py-2 text-center">${team.P}</td>
                                <td class="border px-4 py-2 text-center">${team.D}</td>
                                <td class="border px-4 py-2 text-center">${team.GF}</td>
                                <td class="border px-4 py-2 text-center">${team.GC}</td>
                                <td class="border px-4 py-2 text-center">${team.DG}</td>
                            `;
                            standingsBody.appendChild(row);
                        });
                    })
                    .catch(error => console.error('Error al cargar los datos de la tabla de posiciones:', error));
            }

            function loadGames(tournamentId) {
                fetch(`/league/games/${tournamentId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); // Añade esta línea para verificar la respuesta de la API
                        const gamesBody = document.getElementById('games-body');
                        gamesBody.innerHTML = '';
                        const gamesArray = data.games.sort((a, b) => new Date(b.match_date) - new Date(a.match_date)); // Ordenar por fecha de mayor a menor
                        gamesArray.forEach(game => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td class="border px-4 py-2">${new Date(game.match_date).toLocaleDateString()}</td>
                                <td class="border px-4 py-2">${game.team1.name}</td>
                                <td class="border px-4 py-2">${game.team2.name}</td>
                                <td class="border px-4 py-2">${game.location}</td>
                                <td class="border px-4 py-2">${game.referee.name}</td>
                            `;
                            gamesBody.appendChild(row);
                        });
                    })
                    .catch(error => console.error('Error al cargar los datos de los partidos:', error));
            }
        </script>
    </body>
</html>