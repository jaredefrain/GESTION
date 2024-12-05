@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Finanzas</h1>
        <a href="{{ route('admin.finances.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Agregar Registro Financiero</a>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Tipo</th>
                        <th class="py-2 px-4 border-b">Monto</th>
                        <th class="py-2 px-4 border-b">Descripción</th>
                        <th class="py-2 px-4 border-b">Torneo</th>
                        <th class="py-2 px-4 border-b">Equipo</th>
                        <th class="py-2 px-4 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($finances as $finance)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $finance->type }}</td>
                            <td class="py-2 px-4 border-b">{{ $finance->amount }}</td>
                            <td class="py-2 px-4 border-b">{{ $finance->description }}</td>
                            <td class="py-2 px-4 border-b">{{ $finance->tournament ? $finance->tournament->name : '-' }}</td>
                            <td class="py-2 px-4 border-b">{{ $finance->team ? $finance->team->name : '-' }}</td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('admin.finances.edit', $finance) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Editar</a>
                                <form action="{{ route('admin.finances.destroy', $finance) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection