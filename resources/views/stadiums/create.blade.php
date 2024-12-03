@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($stadium) ? 'Editar Estadio' : 'Crear Estadio' }}</h1>
    <form action="{{ isset($stadium) ? route('stadiums.update', $stadium) : route('stadiums.store') }}" method="POST">
        @csrf
        @if(isset($stadium))
            @method('PUT')
        @endif
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $stadium->name ?? '') }}" required>
        </div>
        <div class="form-group">
            <label for="team_id">Equipo</label>
            <select name="team_id" class="form-control" required>
                @foreach($teams as $id => $name)
                    <option value="{{ $id }}" {{ (isset($stadium) && $stadium->team_id == $id) ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="has_event">¿Tiene Evento?</label>
            <select name="has_event" class="form-control" id="has_event" required>
                <option value="0" {{ (isset($stadium) && !$stadium->has_event) ? 'selected' : '' }}>No</option>
                <option value="1" {{ (isset($stadium) && $stadium->has_event) ? 'selected' : '' }}>Sí</option>
            </select>
        </div>
        <div id="event_details" style="display: {{ (isset($stadium) && $stadium->has_event) ? 'block' : 'none' }};">
            <div class="form-group">
                <label for="event_start">Inicio del Evento</label>
                <input type="datetime-local" name="event_start" class="form-control" value="{{ old('event_start', isset($stadium) ? $stadium->event_start->format('Y-m-d\TH:i') : '') }}">
            </div>
            <div class="form-group">
                <label for="event_end">Fin del Evento</label>
                <input type="datetime-local" name="event_end" class="form-control" value="{{ old('event_end', isset($stadium) ? $stadium->event_end->format('Y-m-d\TH:i') : '') }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ isset($stadium) ? 'Actualizar' : 'Crear' }}</button>
    </form>
</div>

<script>
document.getElementById('has_event').addEventListener('change', function() {
    document.getElementById('event_details').style.display = this.value == '1' ? 'block' : 'none';
});
</script>
@endsection