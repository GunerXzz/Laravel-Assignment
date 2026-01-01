<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        // Cleaner query using the scopeSearch method in the Model
        $rooms = Room::with('roomType')
            ->search($search)
            ->latest()
            ->paginate(8)
            ->withQueryString();

        // Statistics for cards
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();

        return view('rooms.index', compact(
            'rooms',
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'maintenanceRooms',
            'search'
        ));
    }

    public function create()
    {
        $roomTypes = RoomType::orderBy('name')->get();
        return view('rooms.create', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_type_id' => ['required', 'exists:room_types,id'],
            'room_number'  => ['required', 'string', 'max:50', 'unique:rooms,room_number'],
            'floor'        => ['nullable', 'integer', 'min:0'],
            'status'       => ['required', Rule::in(['available', 'occupied', 'maintenance'])],
        ]);

        Room::create($data);

        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }

    public function edit(Room $room)
    {
        $roomTypes = RoomType::orderBy('name')->get();
        return view('rooms.edit', compact('room', 'roomTypes'));
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'room_type_id' => ['required', 'exists:room_types,id'],
            'room_number'  => ['required', 'string', 'max:50', Rule::unique('rooms', 'room_number')->ignore($room->id)],
            'floor'        => ['nullable', 'integer', 'min:0'],
            'status'       => ['required', Rule::in(['available', 'occupied', 'maintenance'])],
        ]);

        $room->update($data);

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
}