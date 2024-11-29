@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Partidos</h1>
    <a href="{{ route('admin.games.create') }}" class="btn btn-primary">Crear Partido</a>

    <div class="form-group mt-4">
        <label for="tournamentFilter">Filtrar por Torneo:</label>
        <select id="tournamentFilter" class="form-control">
            <option value="">Todos los Torneos</option>
            @foreach($tournaments as $tournament)
                <option value="{{ $tournament->name }}">{{ $tournament->name }}</option>
            @endforeach
        </select>
    </div>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Torneo</th>
                <th>Equipo 1</th>
                <th>Equipo 2</th>
                <th>Árbitro</th>
                <th>Fecha del Partido</th>
                <th>Ubicación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($games as $game)
                <tr class="game-row"
                    data-tournament="{{ $game->tournament->name }}"
                    data-match-date="{{ $game->match_date->format('Y-m-d\TH:i:s') }}">
                    <td>{{ $game->id }}</td>
                    <td>{{ $game->tournament->name }}</td>
                    <td>{{ $game->team1->name }}</td>
                    <td>{{ $game->team2->name }}</td>
                    <td>{{ $game->referee->name }}</td>
                    <td>{{ $game->match_date->format('d/m/Y H:i') }}</td>
                    <td>{{ $game->location }}</td>
                    <td>
                        @if($game->match_date->isPast())
                            <a href="{{ route('admin.games.manage', $game->id) }}" class="btn btn-secondary">Gestionar Partido</a>
                        @endif
                        <a href="{{ route('admin.games.edit', $game) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('admin.games.destroy', $game) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Filtrar por torneo
        $('#tournamentFilter').on('change', function() {
            var selectedTournament = $(this).val().toLowerCase();
            $('.game-row').each(function() {
                var tournament = $(this).data('tournament').toLowerCase();
                if (selectedTournament === "" || tournament === selectedTournament) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Colorear filas según la fecha del partido usando Bootstrap
        $('.game-row').each(function() {
            var matchDateStr = $(this).data('match-date');
            console.log('Fecha del Partido:', matchDateStr); // Debugging
            var matchDate = new Date(matchDateStr);
            var now = new Date();
            console.log('Fecha del Partido:', matchDate); // Debugging
            console.log('Ahora:', now); // Debugging

            if (matchDate < now) {
                console.log('Aplicando clase de éxito de Bootstrap');
                $(this).addClass('table-success'); // Fila verde
            } else {
                console.log('Aplicando clase de advertencia de Bootstrap');
                $(this).addClass('table-warning'); // Fila amarilla
            }
        });

        // Verificar las clases aplicadas
        $('.game-row').each(function() {
            console.log('Clases de la fila:', $(this).attr('class'));
        });
    });
</script>
@endsection
