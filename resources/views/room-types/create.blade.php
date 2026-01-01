<x-app-layout>
    <x-slot name="header">Add Room Type</x-slot>

    <div class="glass-card p-4 form-glow">
        <form method="POST" action="{{ route('room-types.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Room Type Name</label>
                    <input class="form-control" name="name" value="{{ old('name') }}" required>
                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Price per Night ($)</label>
                    <input class="form-control" type="number" step="0.01" name="price_per_night" value="{{ old('price_per_night') }}" required>
                    @error('price_per_night') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" rows="3" name="description">{{ old('description') }}</textarea>
                    @error('description') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Room Type Image (Optional)</label>
                    <input class="form-control" type="file" name="image" accept="image/*">
                    @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    <div class="muted small mt-1">JPG / PNG / WEBP (max 2MB)</div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button class="btn-glow" type="submit">
                    <i class="bi bi-check2-circle me-1"></i> Save
                </button>
                <a class="btn btn-outline-secondary" href="{{ route('room-types.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
