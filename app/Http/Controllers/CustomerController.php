<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $customers = Customer::with(['bookings' => fn($q) => $q->latest()->with('rooms:id,room_number')])
            ->search($search)
            ->latest()
            ->paginate(8)
            ->withQueryString();

        // Cards
        $totalCustomers = Customer::count();
        $customersWithBookings = Customer::has('bookings')->count();
        $activeCustomers = Customer::whereHas('bookings', function ($q) {
            $q->whereIn('status', ['booked', 'checked_in']);
        })->count();

        return view('customers.index', compact(
            'customers', 'totalCustomers', 'customersWithBookings', 
            'activeCustomers', 'search'
        ));
    }
    
    // ... create, store, edit, update, destroy methods remain largely the same, they were already clean.
    
    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:120'],
            'phone' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:120'],
            'id_number' => ['nullable', 'string', 'max:80'],
        ]);

        Customer::create($data);

        return redirect()->route('customers.index')->with('success', 'Customer added successfully.');
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:120'],
            'phone' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:120'],
            'id_number' => ['nullable', 'string', 'max:80'],
        ]);

        $customer->update($data);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}