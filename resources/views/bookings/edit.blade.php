<x-app-layout>
    <x-slot name="header">Edit Booking</x-slot>

    <div class="glass-card p-4 form-glow">
        <form method="POST" action="{{ route('bookings.update', $booking) }}">
            @csrf
            @method('PUT')

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Customer</label>
                    <select class="form-select" name="customer_id" required>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}" @selected(old('customer_id', $booking->customer_id) == $c->id)>
                                {{ $c->full_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Check In</label>
                    <input class="form-control" type="date" name="check_in" value="{{ old('check_in', $booking->check_in) }}" required>
                    @error('check_in') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Check Out</label>
                    <input class="form-control" type="date" name="check_out" value="{{ old('check_out', $booking->check_out) }}" required>
                    @error('check_out') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status" required>
                        @foreach(['booked','checked_in','checked_out','cancelled'] as $st)
                            <option value="{{ $st }}" @selected(old('status', $booking->status) === $st)>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">
                    <i class="bi bi-door-open-fill me-1"></i> Rooms
                </label>

                @error('room_ids') <div class="text-danger small mb-2">{{ $message }}</div> @enderror

                <select class="form-select" name="room_ids[]" multiple size="8" required>
                    @php $selected = collect(old('room_ids', $booking->rooms->pluck('id')->all())); @endphp
                    @foreach($rooms as $r)
                        <option value="{{ $r->id }}" @selected($selected->contains($r->id))>
                            Room {{ $r->room_number }} ({{ $r->status }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Note</label>
                <textarea class="form-control" rows="2" name="note">{{ old('note', $booking->note) }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button class="btn-glow" type="submit">
                    <i class="bi bi-save2 me-1"></i> Update Booking
                </button>
                <a class="btn btn-outline-secondary" href="{{ route('bookings.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
