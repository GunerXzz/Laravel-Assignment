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

                <h2 class="fw-bold mb-2">Welcome back 👋</h2>
                <p class="muted mb-4">Login as staff to manage rooms, bookings, customers, and room types.</p>

                {{-- Public illustration (no local file needed) --}}
                <div class="text-center">
                    <img
                        src="https://illustrations.popsy.co/white/remote-work.svg"
                        alt="Welcome"
                        class="img-fluid"
                        style="max-height: 320px;"
                    >
                </div>

                <div class="mt-4 muted">
                    <i class="bi bi-shield-check me-1"></i>
                    Staff-only access
                </div>
            </div>
        </div>

        {{-- Right login form --}}
        <div class="col-lg-6">
            <div class="soft-card p-4 h-100">
                <h4 class="fw-bold mb-1">Staff Login</h4>
                <p class="muted mb-4">Enter your staff account details.</p>

                <x-auth-session-status class="mb-3" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
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

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                            <label class="form-check-label" for="remember_me">Remember me</label>
                        </div>

                        @if (Route::has('password.request'))
                            <a class="text-decoration-none" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button class="btn btn-primary w-100" type="submit">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Login
                    </button>

                    <div class="text-center mt-3">
                        <span class="muted">No account?</span>
                        <a class="text-decoration-none" href="{{ route('register') }}">Register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
