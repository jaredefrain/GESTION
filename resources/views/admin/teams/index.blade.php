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
                            <a href="{{ route('teams.edit', $team) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Editar</a>
                            <form action="{{ route('teams.destroy', $team) }}" method="POST" class="inline-block">
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

<!-- The Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <img id="modalImage" src="" alt="Team Logo" class="w-full">
    </div>
</div>

<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
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
</script>
@endsection