<x-app-layout>
    <x-slot name="header">Room Types</x-slot>

    @if(session('success'))
        <div class="alert alert-success soft-card mb-3">
            <i class="bi bi-check-circle me-1"></i>{{ session('success') }}
        </div>
    @endif

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <div>
            <div class="fw-bold">Room Types</div>
            <div class="muted">Pricing + description + image</div>
        </div>

        <a href="{{ route('room-types.create') }}" class="btn-glow">
            <i class="bi bi-plus-circle me-1"></i> Add Room Type
        </a>
    </div>

    <div class="glass-card p-3">
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="neon-card neon-indigo">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75">Total Room Types</div>
                            <div class="fs-4 fw-bold">{{ $totalTypes }}</div>
                        </div>
                        <div class="neon-icon">
                            <i class="bi bi-layers"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="neon-card neon-green">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75">Lowest Price / Night</div>
                            <div class="fs-4 fw-bold">${{ number_format($lowestPrice, 2) }}</div>
                        </div>
                        <div class="neon-icon">
                            <i class="bi bi-arrow-down-circle"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="neon-card neon-orange">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="small opacity-75">Highest Price / Night</div>
                            <div class="fs-4 fw-bold">${{ number_format($highestPrice, 2) }}</div>
                        </div>
                        <div class="neon-icon">
                            <i class="bi bi-arrow-up-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-borderless table-soft align-middle mb-0">
                <thead class="muted">
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price / Night</th>
                        <th>Description</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($roomTypes as $rt)
                        <tr>
                            <td style="width:90px;">
                                @if($rt->image)
                                    <img
                                        src="{{ asset('storage/'.$rt->image) }}"
                                        alt="Room type image"
                                        style="width:72px;height:48px;object-fit:cover;border-radius:12px;"
                                    >
                                @else
                                    <div class="muted small">No image</div>
                                @endif
                            </td>

                            <td class="fw-semibold">{{ $rt->name }}</td>

                            <td class="muted">${{ number_format($rt->price_per_night, 2) }}</td>

                            <td class="muted">{{ \Illuminate\Support\Str::limit($rt->description, 60) }}</td>

                            <td class="text-end">
                                <a href="{{ route('room-types.edit', $rt) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('room-types.destroy', $rt) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Delete this room type?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center muted py-4">No room types yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $roomTypes->links() }}
        </div>
    </div>
</x-app-layout>
