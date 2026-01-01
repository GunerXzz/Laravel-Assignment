<x-guest-layout>
    <div class="row g-4 align-items-stretch py-4">
        {{-- Left welcome panel --}}
        <div class="col-lg-6">
            <div class="soft-card p-4 h-100" style="background: linear-gradient(135deg, rgba(79,70,229,.12), rgba(14,165,233,.10));">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <span style="width:10px;height:10px;border-radius:999px;background:var(--accent);display:inline-block;"></span>
                        <div class="fw-bold">Hotel Booking System</div>
                    </div>

                    <button class="btn btn-sm btn-outline-secondary" type="button" onclick="toggleTheme()">
                        <i class="bi bi-moon-stars"></i>
                    </button>
                </div>

                <h2 class="fw-bold mb-2">Create staff account ✨</h2>
                <p class="muted mb-4">Register once, then login to manage rooms and bookings.</p>

                <div class="text-center">
                    <img
                    src="https://illustrations.popsy.co/white/remote-work.svg"
                    class="img-fluid"
                    style="max-height: 240px;"
                    >
                </div>

                <div class="mt-4 muted">
                    <i class="bi bi-lightning-charge me-1"></i>
                    Quick setup for staff
                </div>
            </div>
        </div>

        {{-- Right register form --}}
        <div class="col-lg-6">
            <div class="soft-card p-4 h-100">
                <h4 class="fw-bold mb-1">Staff Register</h4>
                <p class="muted mb-4">Fill in your details.</p>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus>
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input class="form-control" type="password" name="password" required>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input class="form-control" type="password" name="password_confirmation" required>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <button class="btn btn-primary w-100" type="submit">
                        <i class="bi bi-person-plus me-1"></i> Register
                    </button>

                    <div class="text-center mt-3">
                        <span class="muted">Already have an account?</span>
                        <a class="text-decoration-none" href="{{ route('login') }}">Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
