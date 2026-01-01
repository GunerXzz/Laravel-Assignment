<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Room;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalRooms = Room::count();
        $totalBookings = Booking::count();
        $totalCustomers = Customer::count();

        // "Available today" (simple version)
        // We treat a room as unavailable today if it has a booking overlapping today
        $today = now()->toDateString();

        $roomsBookedTodayIds = Booking::where('status', '!=', 'cancelled')
            ->where('check_in', '<=', $today)
            ->where('check_out', '>', $today) // checkout same day is NOT occupying today
            ->with('rooms:id')
            ->get()
            ->pluck('rooms')
            ->flatten()
            ->pluck('id')
            ->unique()
            ->values()
            ->all();

        $availableRoomsCount = Room::whereNotIn('id', $roomsBookedTodayIds)
            ->where('status', 'available')
            ->count();

        $recentBookings = Booking::with(['customer:id,full_name', 'rooms:id,room_number'])
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', compact(
            'totalRooms',
            'totalBookings',
            'totalCustomers',
            'availableRoomsCount',
            'recentBookings'
        ));
    }
}
