<x-app-layout>
    <x-slot name="header">Edit Room</x-slot>

    <div class="glass-card p-4 form-glow">
        <form method="POST" action="{{ route('rooms.update', $room) }}">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Room Number</label>
                    <input class="form-control" name="room_number" value="{{ old('room_number', $room->room_number) }}" required>
                    @error('room_number') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Room Type</label>
                    <select class="form-select" name="room_type_id" required>
                        @foreach($roomTypes as $t)
                            <option value="{{ $t->id }}" @selected(old('room_type_id', $room->room_type_id) == $t->id)>{{ $t->name }}</option>
                        @endforeach
                    </select>
                    @error('room_type_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Floor</label>
                    <input class="form-control" type="number" name="floor" value="{{ old('floor', $room->floor) }}">
                    @error('floor') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status" required>
                        <option value="available" @selected(old('status', $room->status)==='available')>Available</option>
                        <option value="occupied" @selected(old('status', $room->status)==='occupied')>Occupied</option>
                        <option value="maintenance" @selected(old('status', $room->status)==='maintenance')>Maintenance</option>
                    </select>
                    @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button class="btn-glow" type="submit">
                    <i class="bi bi-save2 me-1"></i> Update
                </button>
                <a class="btn btn-outline-secondary" href="{{ route('rooms.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>

