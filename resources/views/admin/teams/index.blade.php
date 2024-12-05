@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Equipos</h1>
        <a href="{{ route('teams.create') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Crear Equipo</a>
        <table class="table-auto w-full mt-4">
            <thead>
                <tr>
                    <th class="px-4 py-2">Nombre</th>
                    <th class="px-4 py-2">Logo</th>
                    <th class="px-4 py-2">Jugadores</th>
                    <th class="px-4 py-2">Entrenadores</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teams as $team)
                    <tr>
                        <td class="border px-4 py-2">{{ $team->name }}</td>
                        <td class="border px-4 py-2">
                            @if ($team->logo)
                                <img src="{{ Storage::url($team->logo) }}" alt="{{ $team->name }}" class="w-16 h-16 cursor-pointer" onclick="showModal('{{ Storage::url($team->logo) }}')">
                            @endif
                        </td>
                        <td class="border px-4 py-2">
                            <ul>
                                @foreach ($team->players as $player)
                                    <li class="flex justify-between items-center">
                                        {{ $player->name }}
                                        <form action="{{ route('teams.removePlayer', ['team' => $team->id, 'player' => $player->id]) }}" method="POST" class="inline-block ml-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Eliminar</button>
                                        </form>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="border px-4 py-2">
                            <ul>
                                @foreach ($team->coaches as $coach)
                                    <li>{{ $coach->name }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="border px-4 py-2">
                            <a href="{{ route('teams.edit', $team) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Editar</a>
                            <form action="{{ route('teams.destroy', $team) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Eliminar</button>
                            </form>
                            <button onclick="showCoachModal({{ $team->id }}, {{ $team->coaches->pluck('id') }})" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Asignar Entrenador</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- The Modal for Team Logo -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <img id="modalImage" src="" alt="Team Logo" class="w-full">
    </div>
</div>

<!-- The Modal for Assigning Coach -->
<div id="coachModal" class="modal">
    <div class="modal-content">
        <span class="close-coach">&times;</span>
        <h2>Asignar Entrenador</h2>
        <form id="assignCoachForm" method="POST" action="">
            @csrf
            <label for="coaches">Seleccionar Entrenadores:</label>
            <div id="coaches">
                @foreach ($coaches as $coach)
                    <div>
                        <input type="checkbox" name="coaches[]" value="{{ $coach->id }}" id="coach_{{ $coach->id }}">
                        <label for="coach_{{ $coach->id }}">{{ $coach->name }}</label>
                    </div>
                @endforeach
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-2">Asignar</button>
        </form>
    </div>
</div>

<script>
    // Get the modal for team logo
    var modal = document.getElementById("myModal");
    var span = document.getElementsByClassName("close")[0];

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    function showModal(imageSrc) {
        var modalImg = document.getElementById("modalImage");
        modal.style.display = "block";
        modalImg.src = imageSrc;
    }

    // Get the modal for assigning coach
    var coachModal = document.getElementById("coachModal");
    var spanCoach = document.getElementsByClassName("close-coach")[0];

    spanCoach.onclick = function() {
        coachModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == coachModal) {
            coachModal.style.display = "none";
        }
    }

    function showCoachModal(teamId, assignedCoaches) {
        var form = document.getElementById("assignCoachForm");
        form.action = '/teams/' + teamId + '/assign-coach';

        // Uncheck all checkboxes
        var checkboxes = document.querySelectorAll('#coaches input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });

        // Check the checkboxes for assigned coaches
        assignedCoaches.forEach(function(coachId) {
            var checkbox = document.getElementById('coach_' + coachId);
            if (checkbox) {
                checkbox.checked = true;
            }
        });

        coachModal.style.display = "block";
    }
</script>
@endsection