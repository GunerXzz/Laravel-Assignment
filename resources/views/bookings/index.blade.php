<x-app-layout>
    <x-slot name="header">Manage Bookings</x-slot>

    @if(session('success'))
        <div class="alert alert-success soft-card mb-3">
            <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
        </div>
    @endif

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <div class="fw-bold">Bookings</div>
            <div class="muted">Create and manage bookings</div>
        </div>

        <a href="{{ route('bookings.create') }}" class="btn btn-primary">
            <i class="bi bi-calendar2-plus me-1"></i> New Booking
        </a>
    </div>

    <div class="glass-card p-3">
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <div class="neon-card neon-indigo">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75">Total Bookings</div>
                            <div class="fs-4 fw-bold">{{ $totalBookings }}</div>
                        </div>
                        <div class="neon-icon">
                            <i class="bi bi-calendar-week"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="neon-card neon-cyan">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75">Active</div>
                            <div class="fs-4 fw-bold">{{ $activeBookings }}</div>
                        </div>
                        <div class="neon-icon">
                            <i class="bi bi-lightning-charge"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="neon-card neon-green">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75">Checked-in</div>
                            <div class="fs-4 fw-bold">{{ $checkedInCount }}</div>
                        </div>
                        <div class="neon-icon">
                            <i class="bi bi-box-arrow-in-right"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="neon-card neon-orange">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75">Checked-outs</div>
                            <div class="fs-4 fw-bold">{{ $checkedOutCount }}</div>
                        </div>
                        <div class="neon-icon">
                            <i class="bi bi-box-arrow-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="table-responsive">
        <table class="table table-borderless table-soft align-middle mb-0">
                <thead class="muted">
                    <tr>
                        <th>Customer</th>
                        <th>Rooms</th>
                        <th>Dates</th>
                        <th>Note</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $b)
                        <tr>
                            <td class="fw-semibold">{{ $b->customer->full_name ?? '—' }}</td>
                            <td class="muted">{{ $b->rooms->pluck('room_number')->join(', ') ?: '—' }}</td>
                            <td class="muted">{{ $b->check_in }} → {{ $b->check_out }}</td>
                            <td class="muted">{{ \Illuminate\Support\Str::limit($b->note, 40) ?: '—' }}</td>
                            <td><span class="badge text-bg-secondary">{{ $b->status }}</span></td>

                            <td class="text-end">
                                <a href="{{ route('bookings.edit', $b) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('bookings.destroy', $b) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this booking?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center muted py-4">No bookings yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $bookings->links() }}
        </div>
    </div>
</x-app-layout>
