@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h1 class="h3 mb-0">Crear Equipo</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('teams.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo:</label>
                            <input type="file" name="logo" id="logo" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="players" class="form-label">Jugadores:</label>
                            <select name="players[]" id="players" class="form-select" multiple>
                                @foreach ($players as $player)
                                    <option value="{{ $player->id }}">{{ $player->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection