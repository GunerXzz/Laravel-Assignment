<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="container-fluid">

        {{-- Welcome banner --}}
        <div class="soft-card p-4 mb-4"
             style="background: linear-gradient(135deg, #6366f1, #22d3ee); color: white;">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <div class="opacity-75">Hotel Booking Management</div>
                    <h3 class="fw-bold mb-1">Welcome back, {{ auth()->user()->name }} 👋</h3>
                    <div class="opacity-75">Manage your hotel operations at a glance</div>
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('bookings.index') }}"
                       class="btn btn-light fw-semibold">
                        <i class="bi bi-calendar2-plus me-1"></i> New Booking
                    </a>
                    <a href="{{ route('rooms.index') }}"
                       class="btn btn-outline-light fw-semibold">
                        <i class="bi bi-door-open me-1"></i> Rooms
                    </a>
                </div>
            </div>
        </div>

        {{-- Neon Stats Cards --}}
        <div class="row g-4 mb-4">

            {{-- Total Rooms --}}
            <div class="col-md-6 col-xl-3">
                <div class="neon-card neon-indigo h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="opacity-75">Total Rooms</div>
                            <div class="fs-2 fw-bold">{{ $totalRooms }}</div>
                        </div>
                        <div class="neon-icon">
                            <i class="bi bi-door-open-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Bookings --}}
            <div class="col-md-6 col-xl-3">
                <div class="neon-card neon-cyan h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="opacity-75">Total Bookings</div>
                            <div class="fs-2 fw-bold">{{ $totalBookings }}</div>
                        </div>
                        <div class="neon-icon">
                            <i class="bi bi-calendar-check-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Total Customers --}}
            <div class="col-md-6 col-xl-3">
                <div class="neon-card neon-green h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="opacity-75">Customers</div>
                            <div class="fs-2 fw-bold">{{ $totalCustomers }}</div>
                        </div>
                        <div class="neon-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Available Today --}}
            <div class="col-md-6 col-xl-3">
                <div class="neon-card neon-orange h-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="opacity-75">Available Today</div>
                            <div class="fs-2 fw-bold">{{ $availableRoomsCount }}</div>
                        </div>
                        <div class="neon-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        {{-- Chart + Recent bookings --}}
        <div class="row g-3">

            {{-- Chart --}}
            <div class="col-lg-7">
                <div class="glass-card p-4 form-glow h-100">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <div class="fw-bold">Bookings Overview</div>
                            <div class="muted">Static sample data</div>
                        </div>
                        <span class="badge rounded-pill text-bg-primary">Chart</span>
                    </div>

                    <canvas id="bookingChart" height="120"></canvas>
                </div>
            </div>

            {{-- Recent bookings --}}
            <div class="col-lg-5">
                <div class="glass-card p-4 form-glow h-100">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <div class="fw-bold">Recent Bookings</div>
                            <div class="muted">Latest activity</div>
                        </div>
                        <a href="{{ route('bookings.index') }}" class="text-decoration-none fw-semibold">
                            View all <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <tbody>
                                @forelse($recentBookings as $b)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $b->customer->full_name ?? '—' }}</div>
                                            <div class="muted small">
                                                Rooms: {{ $b->rooms->pluck('room_number')->join(', ') ?: '—' }}
                                            </div>
                                        </td>
                                        <td class="text-end muted small">
                                            {{ $b->check_in }}<br>
                                            → {{ $b->check_out }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="muted text-center py-4">
                                            No bookings yet
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- Chart.js --}}
    <script>
        const ctx = document.getElementById('bookingChart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul'],
                    datasets: [{
                        label: 'Bookings',
                        data: [4, 7, 5, 10, 8, 12, 9],
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79,70,229,.15)',
                        fill: true,
                        tension: 0.35
                    }]
                },
                options: {
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }
    </script>
</x-app-layout>
