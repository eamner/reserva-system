@extends('layouts.app')
@section('content')
<div class="max-w-lg container mx-auto p-6 mt-8 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-bold mb-6">Crear Nueva Reserva</h1>

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('reservations.store') }}" method="POST" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 space-y-4">
        @csrf
        <div>
            <label for="user_id" class="block text-sm font-medium">Usuario</label>
            <select name="user_id" class="w-full border rounded p-2">
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            @error('user_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="resource_id" class="block text-sm font-medium">Recurso</label>
            <select name="resource_id" class="w-full border rounded p-2">
                @foreach($resources as $resource)
                <option value="{{ $resource->id }}">{{ $resource->name }}</option>
                @endforeach
            </select>
            @error('resource_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="start_time" class="block text-sm font-medium">Inicio</label>
            <input type="datetime-local" name="start_time" id="start_time" class="mt-1 w-full border rounded p-2" required>
            @error('start_time')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="end_time" class="block text-sm font-medium">Fin</label>
            <input type="datetime-local" name="end_time" id="end_time" class="mt-1 w-full border rounded p-2" required>
            @error('end_time')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <a href="{{ route('reservations.index') }}" class="px-4 py-2 bg-gray-300 rounded mr-2">Cancelar</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
        </div>
    </form>
</div>
@endsection