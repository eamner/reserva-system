@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Crear nueva reservación</h1>

    @if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <ul class="list-disc ml-5">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('reservations.store') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-gray-700 mb-1 font-medium">Recurso</label>
            <select name="resource_id" class="w-full border border-gray-300 rounded p-2">
                @foreach ($resources as $resource)
                <option value="{{ $resource->id }}">{{ $resource->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700 mb-1 font-medium">Usuario</label>
            <select name="user_id" class="w-full border border-gray-300 rounded p-2">
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-gray-700 mb-1 font-medium">Descripción</label>
            <textarea name="description" rows="3" class="w-full border border-gray-300 rounded p-2">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 mb-1 font-medium">Inicio</label>
                <input type="datetime-local" name="start_time" class="w-full border border-gray-300 rounded p-2" value="{{ old('start_time') }}">
            </div>
            <div>
                <label class="block text-gray-700 mb-1 font-medium">Fin</label>
                <input type="datetime-local" name="end_time" class="w-full border border-gray-300 rounded p-2" value="{{ old('end_time') }}">
            </div>
        </div>

        <div>
            <label class="block text-gray-700 mb-1 font-medium">Estado</label>
            <select name="status" class="w-full border border-gray-300 rounded p-2">
                <option value="open">Pendiente</option>
                <option value="accepted">Aprobada</option>
                <option value="cancelled">Rechazada</option>
            </select>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                Guardar Reservación
            </button>
        </div>
    </form>
</div>
@endsection