<x-app-layout>
    <x-slot name="header">Customer Info</x-slot>

    @if(session('success'))
        <div class="alert alert-success soft-card mb-3">
            <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
        </div>
    @endif

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <div class="fw-bold">Customers</div>
            <div class="muted">Manage customer details</div>
        </div>

        <a href="{{ route('customers.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus me-1"></i> Add Customer
        </a>
    </div>

    <div class="glass-card p-3">
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="neon-card neon-indigo">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75">Total Customers</div>
                            <div class="fs-4 fw-bold">{{ $totalCustomers }}</div>
                        </div>
                        <div class="neon-icon">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="neon-card neon-cyan">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75">With Bookings</div>
                            <div class="fs-4 fw-bold">{{ $customersWithBookings }}</div>
                        </div>
                        <div class="neon-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="neon-card neon-green">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75">Active Customers</div>
                            <div class="fs-4 fw-bold">{{ $activeCustomers }}</div>
                        </div>
                        <div class="neon-icon">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="table-responsive">
        <table class="table table-borderless table-soft align-middle mb-0">
                <thead class="muted">
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Booked Rooms</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $c)
                        @php
                            $latestBooking = $c->bookings->first(); // because we loaded bookings latest()
                            $bookedRooms = $latestBooking?->rooms?->pluck('room_number')->join(', ') ?: '—';
                            $bookingStatus = $latestBooking?->status ?? '—';
                        @endphp

                        <tr>
                            <td class="fw-semibold">{{ $c->full_name }}</td>
                            <td class="muted">{{ $c->phone ?? '—' }}</td>
                            <td class="muted">{{ $c->email ?? '—' }}</td>
                            <td class="muted">{{ $bookedRooms }}</td>
                            <td>
                                @if($bookingStatus === 'booked')
                                    <span class="badge bg-secondary">Booked</span>
                                @elseif($bookingStatus === 'checked_in')
                                    <span class="badge bg-success">Checked-in</span>
                                @elseif($bookingStatus === 'checked_out')
                                    <span class="badge bg-info">Checked-out</span>
                                @elseif($bookingStatus === 'cancelled')
                                    <span class="badge bg-danger">Cancelled</span>
                                @else
                                    <span class="badge bg-light text-dark">—</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('customers.edit', $c) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('customers.destroy', $c) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this customer?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center muted py-4">
                                No customers yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $customers->links() }}
        </div>
    </div>
</x-app-layout>
