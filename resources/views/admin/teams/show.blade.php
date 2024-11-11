@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">{{ $team->name }}</h1>
        @if ($team->logo)
            <img id="teamLogo" src="{{ Storage::url($team->logo) }}" alt="{{ $team->name }}" class="w-32 h-32 cursor-pointer">
        @endif
        <h2 class="text-xl font-bold mt-4">Jugadores</h2>
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
        <a href="{{ route('teams.index') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-4">Volver</a>
    </div>
</div>

<!-- The Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <img id="modalImage" src="" alt="{{ $team->name }}" class="w-full">
    </div>
</div>

<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the image and insert it inside the modal
    var img = document.getElementById("teamLogo");
    var modalImg = document.getElementById("modalImage");

    img.onclick = function(){
        modal.style.display = "block";
        modalImg.src = this.src;
    }

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
</script>
@endsection