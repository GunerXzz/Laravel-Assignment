<x-app-layout>
    <x-slot name="header">Manage Rooms</x-slot>

    @if(session('success'))
        <div class="alert alert-success soft-card mb-3">{{ session('success') }}</div>
    @endif

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <div class="fw-bold">Rooms</div>
            <div class="muted">Create rooms and assign room types</div>
        </div>

        <a href="{{ route('rooms.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Room
        </a>
    </div>

    <div class="glass-card p-3">
        <div class="row g-3 mb-3">
            <div class="col-md-3">
                <div class="neon-card neon-indigo">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75">Total Rooms</div>
                            <div class="fs-4 fw-bold">{{ $totalRooms }}</div>
                        </div>
                        <div class="neon-icon">
                            <i class="bi bi-building"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="neon-card neon-green">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75">Available</div>
                            <div class="fs-4 fw-bold">{{ $availableRooms }}</div>
                        </div>
                        <div class="neon-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="neon-card neon-cyan">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75">Occupied</div>
                            <div class="fs-4 fw-bold">{{ $occupiedRooms }}</div>
                        </div>
                        <div class="neon-icon">
                            <i class="bi bi-door-closed"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="neon-card neon-orange">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75">Maintenance</div>
                            <div class="fs-4 fw-bold">{{ $maintenanceRooms }}</div>
                        </div>
                        <div class="neon-icon">
                            <i class="bi bi-tools"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <div class="table-responsive">
        <table class="table table-borderless table-soft align-middle mb-0">
                <thead class="muted">
                    <tr>
                        <th>Room #</th>
                        <th>Type</th>
                        <th>Floor</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $r)
                        <tr>
                            <td class="fw-semibold">{{ $r->room_number }}</td>
                            <td>{{ $r->roomType->name ?? '—' }}</td>
                            <td class="muted">{{ $r->floor ?? '—' }}</td>
                            <td>
                                @if($r->status === 'available')
                                    <span class="badge text-bg-success">Available</span>
                                @elseif($r->status === 'occupied')
                                    <span class="badge text-bg-warning">Occupied</span>
                                @elseif($r->status === 'maintenance')
                                    <span class="badge text-bg-danger">Maintenance</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('rooms.edit', $r) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('rooms.destroy', $r) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this room?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center muted py-4">No rooms yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $rooms->links() }}
        </div>
    </div>
</x-app-layout>
