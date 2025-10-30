<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resources = Resource::all();
        return view('resources.index', compact('resources'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('resources.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:resources',
            'description' => 'nullable|string',
            'capacity' => 'nullable|integer|min:1',
        ]);

        $resource = Resource::create($validated);
        //return response()->json($resource, 201); // 201 CREATED
        return redirect()->route('resources.index')->with('success', 'Resource created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Resource $resource)
    {
        return response()->json($resource, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resource $resource)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|unique:resources,name,' . $resource->id,
            'description' => 'nullable|string',
            'capacity' => 'sometimes|required|integer|min:1',
        ]);

        $resource->update($data);

        return response()->json($resource, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource)
    {
        $resource->delete();
        return response()->json(null, 204);
    }
}
