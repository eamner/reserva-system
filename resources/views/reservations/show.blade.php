@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded p-6 mt-8">
    <h1 class="text-2xl font-bold mb-4">Reserva #{{ $reservation->id }}</h1>

    <class="grid grid-cols-1 gap-4">
        <div>
            <strong>Recurso:</strong>
            <div class="mt-1">{{ $reservation->resource->name ?? 'N/A' }}</div>
        </div>

        <div>
            <strong>Usuario:</strong>
            <div class="mt-1">{{ $reservation->user->name ?? ($reservation->user_id ?? 'N/A') }}</div>
        </div>

        <div>
            <strong>Fecha:</strong>
            <div class="mt-1">{{ \Illuminate\Support\Carbon::parse($reservation->start_time)->toDateString() }}</div>
        </div>

        <div>
            <strong>Estado:</strong>
            <div class="mt-1">
                <span class="px-2 py-1 rounded text-white
                    @if($reservation->status === 'confirmada') bg-green-500
                    @elseif($reservation->status === 'pendiente') bg-yellow-500
                    @else bg-red-500 @endif">
                    {{ ucfirst($reservation->status ?? 'N/A') }}
                </span>
            </div>
        </div>

        <div class="pt-4 flex space-x-3">
            <a href="{{ route('reservations.index') }}"
                class="bg-gray-200 hover:bg-gray-300 py-2 px-4 rounded">
                Volver a la lista
            </a>
        </div>

        <a href="{{ route('reservations.edit', $reservation) }}"
            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
            Editar Reserva
        </a>

        <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit"
                onclick="return confirm('¿Eliminar esta reserva?')"
                class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Eliminar Reserva
            </button>
        </form>
</div>
</div>
@endsection