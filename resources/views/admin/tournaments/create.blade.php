@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Crear Torneo</h1>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">¡Error!</strong>
                <span class="block sm:inline">Por favor corrige los siguientes errores:</span>
                <ul class="mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.tournaments.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Nombre del Torneo</label>
                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="type" class="block text-gray-700 font-bold mb-2">Tipo de Torneo</label>
                <select name="type" id="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                    <option value="eliminatorias">Eliminatorias</option>
                    <option value="liga">Liga</option>
                    <option value="mixto">Mixto</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="number_of_teams" class="block text-gray-700 font-bold mb-2">Número de Equipos</label>
                <input type="number" name="number_of_teams" id="number_of_teams" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
            </div>
            <div class="mb-4">
                <label for="teams" class="block text-gray-700 font-bold mb-2">Equipos</label>
                <div id="teams" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" style="height: auto;">
                    @foreach($teams as $team)
                        <div class="form-check">
                            <input class="form-check-input team-checkbox" type="checkbox" name="teams[]" value="{{ $team->id }}" id="team{{ $team->id }}">
                            <label class="form-check-label" for="team{{ $team->id }}">
                                {{ $team->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mb-4">
                <label for="referees" class="block text-gray-700 font-bold mb-2">Árbitros</label>
                <div id="referees" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" style="height: auto;">
                    @foreach($referees as $referee)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="referees[]" value="{{ $referee->id }}" id="referee{{ $referee->id }}">
                            <label class="form-check-label" for="referee{{ $referee->id }}">
                                {{ $referee->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Crear Torneo</button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const teamCheckboxes = document.querySelectorAll('.team-checkbox');
        const numberOfTeamsInput = document.getElementById('number_of_teams');

        function updateNumberOfTeams() {
            const selectedTeams = document.querySelectorAll('.team-checkbox:checked').length;
            numberOfTeamsInput.value = selectedTeams;
        }

        teamCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateNumberOfTeams);
        });

        // Initialize the number of teams on page load
        updateNumberOfTeams();
    });
</script>
@endsection