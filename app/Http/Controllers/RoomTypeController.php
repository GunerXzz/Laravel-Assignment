<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $roomTypes = RoomType::when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(8)
            ->withQueryString();

        // cards
        $totalTypes = RoomType::count();
        $lowestPrice = RoomType::min('price_per_night') ?? 0;
        $highestPrice = RoomType::max('price_per_night') ?? 0;

        return view('room-types.index', compact(
            'roomTypes',
            'totalTypes',
            'lowestPrice',
            'highestPrice',
            'search'
        ));
    }



    public function create()
    {
        return view('room-types.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:100'],
            'price_per_night' => ['required','numeric','min:0'],
            'description' => ['nullable','string'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('room-types', 'public');
        }

        RoomType::create($data);

        return redirect()->route('room-types.index')
            ->with('success', 'Room type created successfully.');
    }


    public function edit(RoomType $roomType)
    {
        return view('room-types.edit', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $data = $request->validate([
            'name' => ['required','string','max:100'],
            'price_per_night' => ['required','numeric','min:0'],
            'description' => ['nullable','string'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('room-types', 'public');
        }

        $roomType->update($data);

        return redirect()->route('room-types.index')
            ->with('success', 'Room type updated successfully.');
    }


    public function destroy(RoomType $roomType)
    {
        $roomType->delete();

        return redirect()->route('room-types.index')
            ->with('success', 'Room type deleted successfully.');
    }
}
