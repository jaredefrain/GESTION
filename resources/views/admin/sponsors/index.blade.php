@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mb-4">Patrocinadores</h1>
        <a href="{{ route('admin.sponsors.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Agregar Patrocinador</a>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Nombre</th>
                        <th class="py-2 px-4 border-b">Logo</th>
                        <th class="py-2 px-4 border-b">Sitio Web</th>
                        <th class="py-2 px-4 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sponsors as $sponsor)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $sponsor->name }}</td>
                            <td class="py-2 px-4 border-b"><img src="{{ asset('storage/' . $sponsor->logo) }}" alt="{{ $sponsor->name }}" width="50"></td>
                            <td class="py-2 px-4 border-b"><a href="{{ $sponsor->website }}" target="_blank">{{ $sponsor->website }}</a></td>
                            <td class="py-2 px-4 border-b">
                                <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Editar</a>
                                <form action="{{ route('admin.sponsors.destroy', $sponsor) }}" method="POST" style="display:inline-block;">
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