@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Resources</h1>
    <a href="{{ route('resources.create') }}" class="btn btn-primary mb-3">Add New Resource</a>
    @if($resources->isEmpty())
    <p>No resources available.</p>
    @else
    <table class="min-w-full bg-white border rounded shadow">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4 border">ID</th>
                <th class="py-2 px-4 border">Name</th>
                <th class="py-2 px-4 border">Description</th>
                <th class="py-2 px-4 border">Capacity</th>
                <th class="py-2 px-4 border">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resources as $resource)
            <tr>
                <td class="py-2 px-4 border">{{ $resource->id }}</td>
                <td class="py-2 px-4 border">{{ $resource->name }}</td>
                <td class="py-2 px-4 border">{{ $resource->description }}</td>
                <td class="py-2 px-4 border">{{ $resource->capacity }}</td>
                <td class="py-2 px-4 border">
                    <a href="{{ route('resources.edit', $resource) }}"
                        class="text-blue-500 hover:underline">Edit</a>
                    |
                    <form action="{{ route('resources.destroy', $resource) }}"
                        method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-red-500 hover:underline"
                            onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>