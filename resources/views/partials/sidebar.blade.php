@php
    $route = request()->route() ? request()->route()->getName() : '';
@endphp

<aside class="sidebar">
    {{-- Brand --}}
    <div class="brand sidebar-header">
        <div class="sidebar-logo"><i class="bi bi-building"></i></div>
        <div>
            <div class="system-name">
                Hotel Booking Management System
            </div>
            <div class="user-name">
                {{ auth()->user()->name }}
            </div>
        </div>
    
    </div>


    {{-- Navigation --}}
    <a class="navlink {{ $route === 'dashboard' ? 'active' : '' }}"
       href="{{ route('dashboard') }}">
        <i class="bi bi-grid-1x2-fill"></i>
        Dashboard
    </a>

    <a class="navlink {{ str_starts_with($route, 'rooms.') ? 'active' : '' }}"
       href="{{ route('rooms.index') }}">
        <i class="bi bi-door-open-fill"></i>
        Manage Rooms
    </a>

    <a class="navlink {{ str_starts_with($route, 'bookings.') ? 'active' : '' }}"
       href="{{ route('bookings.index') }}">
        <i class="bi bi-calendar2-check-fill"></i>
        Manage Bookings
    </a>

    <a class="navlink {{ str_starts_with($route, 'customers.') ? 'active' : '' }}"
       href="{{ route('customers.index') }}">
        <i class="bi bi-people-fill"></i>
        Customer Info
    </a>

    <a class="navlink {{ str_starts_with($route, 'room-types.') ? 'active' : '' }}"
       href="{{ route('room-types.index') }}">
        <i class="bi bi-layers-fill"></i>
        Room Types
    </a>

    <div class="sidebar-divider"></div>

    {{-- Theme --}}
    <button class="navlink w-100 bg-transparent border-0"
            type="button"
            onclick="toggleTheme()">
        <i class="bi bi-brightness-high-fill"></i>
        Light / Dark
    </button>

    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}" class="mt-2">
        @csrf
        <button class="navlink w-100 bg-transparent border-0 text-start text-danger"
                type="submit">
            <i class="bi bi-box-arrow-right"></i>
            Logout
        </button>
    </form>
</aside>
