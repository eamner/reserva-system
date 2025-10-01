@extends('layouts.app')
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <form action="{{ route('reservations.update', $reservation) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium">Descripción</label>
                        <input type="text" name="description" id="description" rows="3"
                            class="mt-1 w-full border rounded p-2" value="{{ old('description', $reservation->description) }}"></input>
                        @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium">Estado</label>
                        <select name="status" id="status" class="mt-1 w-full border rounded p-2">
                            <option value="open" {{ old('status', $reservation->status) == 'open' ? 'selected' : '' }}>Abierta</option>
                            <option value="accepted" {{ old('status', $reservation->status) == 'accepted' ? 'selected' : '' }}>Aceptada</option>
                            <option value="cancelled" {{ old('status', $reservation->status) == 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                        </select>
                        @error('status')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- SELECCIÓN DE USUARIO Y RECURSO --}}
                    <div>
                        <label for="user_id" class="block text-sm font-medium">Usuario</label>
                        <select name="user_id" id="user_id" class="mt-1 w-full border rounded p-2">
                            @foreach($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('user_id', $reservation->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('user_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="resource_id" class="block text-sm font-medium">Recurso</label>
                        <select name="resource_id" id="resource_id" class="mt-1 w-full border rounded p-2">
                            @foreach($resources as $resource)
                            <option value="{{ $resource->id }}"
                                {{ old('resource_id', $reservation->resource_id) == $resource->id ? 'selected' : '' }}>
                                {{ $resource->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('resource_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- FECHA Y HORA DE INICIO Y FIN --}}
                    <div>
                        <label for="start_time" class="block text-sm font-medium">Inicio</label>
                        <input type="datetime-local" name="start_time" id="start_time"
                            class="mt-1 w-full border rounded p-2"
                            value="{{ old('start_time', \Carbon\Carbon::parse($reservation->start_time)->format('Y-m-d\TH:i')) }}">
                        @error('start_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-medium">Fin</label>
                        <input type="datetime-local" name="end_time" id="end_time"
                            class="mt-1 w-full border rounded p-2"
                            value="{{ old('end_time', \Carbon\Carbon::parse($reservation->end_time)->format('Y-m-d\TH:i')) }}">
                        @error('end_time')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-2">
                        <a href="{{ route('reservations.index') }}" class="px-4 py-2 bg-gray-300 rounded">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection