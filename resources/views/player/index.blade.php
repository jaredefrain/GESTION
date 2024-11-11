@extends('layouts.app') {{-- Asumiendo que la plantilla está en layouts/app.blade.php --}}

@section('content')
<div class="container mx-auto mt-10">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Bien venido, jugador</h1>
        <p class="mb-4">Aqui veras bla bla bla.</p>

        <!-- Tabla de servicios y medicamentos -->
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">

            </thead>
            <tbody class="text-gray-700">

            </tbody>
        </table>

    </div>
</div>
@endsection
