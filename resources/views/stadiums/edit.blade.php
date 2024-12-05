@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Estadio</h1>
    <form action="{{ route('stadiums.update', $stadium) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $stadium->name) }}" required>
        </div>
        <div class="form-group">
            <label for="team_id">Equipo</label>
            <select name="team_id" class="form-control" required>
                @foreach($teams as $id => $name)
                    <option value="{{ $id }}" {{ $stadium->team_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="has_event">¿Tiene Evento?</label>
            <select name="has_event" class="form-control" id="has_event" required>
                <option value="0" {{ !$stadium->has_event ? 'selected' : '' }}>No</option>
                <option value="1" {{ $stadium->has_event ? 'selected' : '' }}>Sí</option>
            </select>
        </div>
        <div id="event_details" style="display: {{ $stadium->has_event ? 'block' : 'none' }};">
            <div class="form-group">
                <label for="event_start">Inicio del Evento</label>
                <input type="datetime-local" name="event_start" class="form-control" value="{{ old('event_start', $stadium->event_start ? $stadium->event_start->format('Y-m-d\TH:i') : '') }}">
            </div>
            <div class="form-group">
                <label for="event_end">Fin del Evento</label>
                <input type="datetime-local" name="event_end" class="form-control" value="{{ old('event_end', $stadium->event_end ? $stadium->event_end->format('Y-m-d\TH:i') : '') }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>

<script>
document.getElementById('has_event').addEventListener('change', function() {
    const eventDetails = document.getElementById('event_details');
    if (this.value == '1') {
        eventDetails.style.display = 'block';
    } else {
        eventDetails.style.display = 'none';
        document.querySelector('input[name="event_start"]').value = '';
        document.querySelector('input[name="event_end"]').value = '';
    }
});
</script>
@endsection