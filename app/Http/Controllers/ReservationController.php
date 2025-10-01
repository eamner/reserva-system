<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Resource;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::orderBy('start_time', 'desc')->paginate(10);
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $resources = Resource::all();
        $users = User::all();
        return view('reservations.create', compact('resources', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'resource_id' => 'required|exists:resources,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);
        Reservation::create($request->all());
        return redirect()->route('reservations.index')->with('success', 'Reserva creada con éxito.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load('resource', 'user');
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        $resources = Resource::all();
        $users = User::all();
        return view('reservations.edit', compact('reservation', 'resources', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'status' => 'required|in:open, accepted, cancelled',
            'user_id' => 'required|exists:users,id',
            'resource_id' => 'required|exists:resources,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $reservation->update($validated);
        return redirect()->route('reservations.index')->with('success', 'Reservación actualizada con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reservación eliminada con éxito.');
    }
}
