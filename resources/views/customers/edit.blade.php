<x-app-layout>
    <x-slot name="header">Edit Customer</x-slot>

    <div class="glass-card p-4 form-glow">
        <form method="POST" action="{{ route('customers.update', $customer) }}">
            @csrf @method('PUT')

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input class="form-control" name="full_name" value="{{ old('full_name', $customer->full_name) }}" required>
                    @error('full_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Phone</label>
                    <input class="form-control" name="phone" value="{{ old('phone', $customer->phone) }}">
                    @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input class="form-control" type="email" name="email" value="{{ old('email', $customer->email) }}">
                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">ID Number</label>
                    <input class="form-control" name="id_number" value="{{ old('id_number', $customer->id_number) }}">
                    @error('id_number') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button class="btn-glow" type="submit">
                    <i class="bi bi-save2 me-1"></i> Update
                </button>
                <a class="btn btn-outline-secondary" href="{{ route('customers.index') }}">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
