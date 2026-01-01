<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $bookings = Booking::with(['customer:id,full_name', 'rooms:id,room_number'])
            ->search($search) // Using the scope from the Model
            ->latest()
            ->paginate(8)
            ->withQueryString();

        // Cards statistics
        $totalBookings = Booking::count();
        $activeBookings = Booking::whereIn('status', ['booked', 'checked_in'])->count();
        $checkedInCount = Booking::where('status', 'checked_in')->count();
        $checkedOutCount = Booking::where('status', 'checked_out')->count();

        return view('bookings.index', compact(
            'bookings', 'totalBookings', 'activeBookings', 
            'checkedInCount', 'checkedOutCount', 'search'
        ));
    }

    public function create()
    {
        $customers = Customer::orderBy('full_name')->get(['id', 'full_name']);
        // Show all rooms except maintenance
        $rooms = Room::where('status', '!=', 'maintenance')
            ->orderBy('room_number')
            ->get(['id', 'room_number', 'status']);

        return view('bookings.create', compact('customers', 'rooms'));
    }

    public function store(Request $request)
    {
        // 1. Validate Input
        $data = $request->validate([
            'customer_id'      => ['nullable', 'exists:customers,id'],
            'use_new_customer' => ['nullable', 'boolean'],
            'new_full_name'    => ['nullable', 'required_if:use_new_customer,1', 'string', 'max:120'],
            'new_phone'        => ['nullable', 'string', 'max:40'],
            'new_email'        => ['nullable', 'email', 'max:120'],
            'new_id_number'    => ['nullable', 'string', 'max:80'],
            'check_in'         => ['required', 'date'],
            'check_out'        => ['required', 'date', 'after:check_in'],
            'status'           => ['required', Rule::in(['booked', 'checked_in', 'checked_out', 'cancelled'])],
            'note'             => ['nullable', 'string'],
            'room_ids'         => ['required', 'array', 'min:1'],
            'room_ids.*'       => ['integer', 'exists:rooms,id'],
        ]);

        if (!$request->boolean('use_new_customer') && empty($data['customer_id'])) {
             return back()->withErrors(['customer_id' => 'Please select a customer or create a new one.'])->withInput();
        }

        // 2. Check for Overlaps (Using helper method)
        $conflicts = $this->getConflictingRoomNumbers($data['room_ids'], $data['check_in'], $data['check_out']);
        
        if ($conflicts->isNotEmpty()) {
            return back()
                ->withErrors(['room_ids' => "Rooms already booked: " . $conflicts->join(', ')])
                ->withInput();
        }

        // 3. Save Data (Transaction)
        DB::transaction(function () use ($data, $request) {
            // Determine Customer ID
            $customerId = $data['customer_id'];

            if ($request->boolean('use_new_customer')) {
                $customer = Customer::create([
                    'full_name' => $data['new_full_name'],
                    'phone'     => $data['new_phone'],
                    'email'     => $data['new_email'],
                    'id_number' => $data['new_id_number'],
                ]);
                $customerId = $customer->id;
            }

            // Create Booking
            $booking = Booking::create([
                'customer_id' => $customerId,
                'check_in'    => $data['check_in'],
                'check_out'   => $data['check_out'],
                'status'      => $data['status'],
                'note'        => $data['note'],
            ]);

            $booking->rooms()->sync($data['room_ids']);
        });

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }

    public function edit(Booking $booking)
    {
        $booking->load(['rooms:id', 'customer:id,full_name']);
        $customers = Customer::orderBy('full_name')->get(['id', 'full_name']);
        $rooms = Room::where('status', '!=', 'maintenance')->orderBy('room_number')->get(['id', 'room_number']);

        return view('bookings.edit', compact('booking', 'customers', 'rooms'));
    }

    public function update(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'check_in'    => ['required', 'date'],
            'check_out'   => ['required', 'date', 'after:check_in'],
            'status'      => ['required', Rule::in(['booked', 'checked_in', 'checked_out', 'cancelled'])],
            'note'        => ['nullable', 'string'],
            'room_ids'    => ['required', 'array', 'min:1'],
            'room_ids.*'  => ['integer', 'exists:rooms,id'],
        ]);

        // Check Overlaps (excluding current booking)
        $conflicts = $this->getConflictingRoomNumbers($data['room_ids'], $data['check_in'], $data['check_out'], $booking->id);

        if ($conflicts->isNotEmpty()) {
            return back()
                ->withErrors(['room_ids' => "Rooms already booked: " . $conflicts->join(', ')])
                ->withInput();
        }

        DB::transaction(function () use ($data, $booking) {
            $booking->update([
                'customer_id' => $data['customer_id'],
                'check_in'    => $data['check_in'],
                'check_out'   => $data['check_out'],
                'status'      => $data['status'],
                'note'        => $data['note'],
            ]);

            $booking->rooms()->sync($data['room_ids']);
        });

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
    }

    /**
     * Check if the selected rooms overlap with existing bookings.
     * Returns a collection of conflicting room numbers.
     */
    private function getConflictingRoomNumbers(array $roomIds, string $checkIn, string $checkOut, ?int $ignoreBookingId = null)
    {
        return Booking::query()
            ->when($ignoreBookingId, fn($q) => $q->where('id', '!=', $ignoreBookingId))
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) use ($checkIn, $checkOut) {
                // Overlap condition: (StartA < EndB) and (EndA > StartB)
                $q->where('check_in', '<', $checkOut)
                  ->where('check_out', '>', $checkIn);
            })
            ->whereHas('rooms', fn($q) => $q->whereIn('rooms.id', $roomIds))
            ->with('rooms:id,room_number')
            ->get()
            ->pluck('rooms')
            ->flatten()
            ->pluck('room_number')
            ->unique();
    }
}