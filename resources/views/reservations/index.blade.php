{{-- resources/views/reservations/index.blade.php --}}

@extends('layouts.app')
@section('content')

<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold mb-6">Reservas</h1>
    <a href="{{ route('reservations.create') }}"
        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mb-4 inline-block">
        + Nueva Reserva
    </a>
    {{-- AGREGAR MENSAJE DE ÉXITO --}}
    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    {{-- TABLA DE RESERVAS --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-5 py-3">ID</th>
                    <th class="px-5 py-3">Recurso</th>
                    <th class="px-5 py-3">Usuario</th>
                    <th class="px-5 py-3">Fecha</th>
                    <th class="px-5 py-3">Estado</th>
                    <th class="px-5 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                <tr class="border-b">
                    <td class="px-5 py-3">{{ $reservation->id }}</td>
                    <td class="px-5 py-3">{{ $reservation->resource->name ?? 'N/A' }}</td>
                    <td class="px-5 py-3">{{ $reservation->user->name }}</td>
                    <td class="px-5 py-3">{{ $reservation->start_time }}</td>
                    <td class="px-5 py-3">
                        <span class="px-2 py-1 rounded text-white
                                    @if($reservation->status === 'confirmada') bg-green-500
                                    @elseif($reservation->status === 'pendiente') bg-yellow-500
                                    @else bg-red-500 @endif">
                            {{ ucfirst($reservation->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 space-x-2">
                        <a href="{{ route('reservations.show', $reservation) }}"
                            class="bg-blue-500 text-white px-2 py-1 rounded">Ver</a>
                        <a href="{{ route('reservations.edit', $reservation) }}"
                            class="bg-yellow-500 text-white px-2 py-1 rounded">Editar</a>
                        <form action="{{ route('reservations.destroy', $reservation) }}"
                            method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                onclick="return confirm('¿Eliminar esta reserva?')"
                                class="bg-red-500 text-white px-2 py-1 rounded">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $reservations->links() }} {{-- PARA LA PAGINACION --}}
        </div>

    </div>
</div>
@endsection