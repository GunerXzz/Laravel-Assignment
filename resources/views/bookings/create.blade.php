<x-app-layout>
    <x-slot name="header">New Booking</x-slot>

    <div class="glass-card p-4 form-glow">
        <form method="POST" action="{{ route('bookings.store') }}">
            @csrf

            {{-- Customer section --}}
            <div class="glass-card p-4 form-glow mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="fw-bold">
                        <i class="bi bi-person-badge me-1"></i> Customer
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="use_new_customer" name="use_new_customer" value="1"
                               {{ old('use_new_customer') ? 'checked' : '' }}>
                        <label class="form-check-label" for="use_new_customer">
                            Add new customer
                        </label>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6" id="existing_customer_box">
                        <label class="form-label">Select Customer</label>
                        <select class="form-select" name="customer_id">
                            <option value="">-- Select customer --</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}" @selected(old('customer_id') == $c->id)>
                                    {{ $c->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12" id="new_customer_box" style="display:none;">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name *</label>
                                <input class="form-control" name="new_full_name" value="{{ old('new_full_name') }}">
                                @error('new_full_name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input class="form-control" name="new_phone" value="{{ old('new_phone') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input class="form-control" type="email" name="new_email" value="{{ old('new_email') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">ID Number</label>
                                <input class="form-control" name="new_id_number" value="{{ old('new_id_number') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Booking info --}}
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">Check In</label>
                    <input class="form-control" type="date" name="check_in" value="{{ old('check_in') }}" required>
                    @error('check_in') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Check Out</label>
                    <input class="form-control" type="date" name="check_out" value="{{ old('check_out') }}" required>
                    @error('check_out') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select class="form-select" name="status" required>
                        <option value="booked" @selected(old('status','booked')==='booked')>booked</option>
                        <option value="checked_in" @selected(old('status')==='checked_in')>checked_in</option>
                        <option value="checked_out" @selected(old('status')==='checked_out')>checked_out</option>
                        <option value="cancelled" @selected(old('status')==='cancelled')>cancelled</option>
                    </select>
                </div>
            </div>

            {{-- Rooms --}}
            <div class="mb-3">
                <label class="form-label fw-bold">
                    <i class="bi bi-door-open-fill me-1"></i> Select Rooms (Multiple)
                </label>

                @error('room_ids') <div class="text-danger small mb-2">{{ $message }}</div> @enderror

                <select class="form-select" name="room_ids[]" multiple size="8" required>
                    @foreach($rooms as $r)
                        <option value="{{ $r->id }}" @selected(collect(old('room_ids',[]))->contains($r->id))>
                            Room {{ $r->room_number }} ({{ $r->status }})
                        </option>
                    @endforeach
                </select>
                <div class="muted small mt-1">Hold Ctrl (Windows) / Cmd (Mac) to select multiple rooms.</div>
            </div>

            {{-- Note --}}
            <div class="mb-3">
                <label class="form-label">Note (Optional)</label>
                <textarea class="form-control" rows="2" name="note">{{ old('note') }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button class="btn-glow" type="submit">
                    <i class="bi bi-check2-circle me-1"></i> Save Booking
                </button>
                <a class="btn btn-outline-secondary" href="{{ route('bookings.index') }}">Cancel</a>
            </div>
        </form>
        
    </div>

    <script>
        function updateCustomerUI() {
            const checked = document.getElementById('use_new_customer').checked;
            document.getElementById('new_customer_box').style.display = checked ? '' : 'none';
            document.getElementById('existing_customer_box').style.display = checked ? 'none' : '';
        }

        document.getElementById('use_new_customer').addEventListener('change', updateCustomerUI);
        updateCustomerUI(); // run on load (handles old input too)
    </script>
</x-app-layout>
