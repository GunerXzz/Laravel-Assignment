<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Hotel') }}</title>

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <!-- Chart.js CDN (for dashboard charts) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <!-- Simple theme variables (Light/Dark) -->
    <style>
        
        /* ===== Sidebar Logo ===== */

        .sidebar-logo {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 20px;
            color: white;
            background: linear-gradient(135deg, #6366f1, #22d3ee);
            box-shadow:
                0 0 12px rgba(99,102,241,.9),
                0 0 25px rgba(34,211,238,.6);
        }


        /* ===== Neon Sidebar ===== */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #0b1530, #020617);
            padding: 22px 18px;
            color: #cbd5f5;
        }

        .sidebar .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 18px;
            font-weight: 800;
            color: #fff;
            margin-bottom: 24px;
        }

        .sidebar .brand-dot {
            width: 12px;
            height: 12px;
            border-radius: 999px;
            background: linear-gradient(135deg, #6366f1, #22d3ee);
            box-shadow: 0 0 12px rgba(99,102,241,.9);
        }

        .sidebar .navlink {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 14px;
            color: #cbd5f5;
            text-decoration: none;
            margin-bottom: 8px;
            transition: all .2s ease;
        }

        .sidebar .navlink i {
            font-size: 18px;
        }

        .sidebar .navlink:hover {
            background: rgba(99,102,241,.15);
            color: #fff;
            box-shadow: inset 0 0 0 1px rgba(99,102,241,.35);
        }

        .sidebar .navlink.active {
            background: linear-gradient(135deg, rgba(99,102,241,.35), rgba(34,211,238,.35));
            color: #fff;
            box-shadow: 0 0 18px rgba(99,102,241,.6);
        }

        .sidebar .sidebar-divider {
            height: 1px;
            background: rgba(255,255,255,.12);
            margin: 16px 0;
        }

        /* ===== Sidebar Header (Logo + Name + User) ===== */

        .sidebar-header {
            display: flex;
            gap: 12px;
            align-items: center;
            margin-bottom: 22px;
        }

        .sidebar-header img {
            width: 46px;
            height: 46px;
            object-fit: contain;
            filter: drop-shadow(0 6px 12px rgba(0,0,0,.45));
        }

        .sidebar-header .system-name {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #a5b4fc;
        }

        .sidebar-header .user-name {
            font-size: 16px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
        }


        /* ===== Neon / Glow Stat Cards ===== */
        .neon-card {
            position: relative;
            border-radius: 18px;
            padding: 18px;
            color: white;
            overflow: hidden;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .neon-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: inherit;
            filter: blur(18px);
            opacity: .7;
            z-index: -1;
        }

        /* Hover lift + glow */
        .neon-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 50px rgba(0,0,0,.35);
        }

        /* Color themes */
        .neon-indigo {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            box-shadow: 0 0 35px rgba(99,102,241,.55);
        }

        .neon-cyan {
            background: linear-gradient(135deg, #06b6d4, #22d3ee);
            box-shadow: 0 0 35px rgba(34,211,238,.55);
        }

        .neon-green {
            background: linear-gradient(135deg, #22c55e, #4ade80);
            box-shadow: 0 0 35px rgba(34,197,94,.55);
        }

        .neon-orange {
            background: linear-gradient(135deg, #fb923c, #f97316);
            box-shadow: 0 0 35px rgba(249,115,22,.55);
        }

        .neon-icon {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255,255,255,.18);
            font-size: 26px;
        }

        :root[data-theme="light"]{
            --bg:#f5f7ff;
            --card:#ffffff;
            --text:#0f172a;
            --muted:#64748b;
            --border:#e5e7eb;
            --sidebar:#0b1530;
            --sidebarText:#cbd5e1;
            --accent:#4f46e5;
            --shadow: 0 10px 30px rgba(15,23,42,.08);
            --radius:18px;
        }
        :root[data-theme="dark"]{
            --bg:#070d1c;
            --card:#0f1a33;
            --text:#e5e7eb;
            --muted:#94a3b8;
            --border:#1f2a44;
            --sidebar:#050a16;
            --sidebarText:#cbd5e1;
            --accent:#8b5cf6;
            --shadow: 0 10px 30px rgba(0,0,0,.35);
            --radius:18px;
        }

        body{ background:var(--bg); color:var(--text); }
        .app-shell{ min-height:100vh; display:flex; }

        /* Sidebar */
        .sidebar{
            width:280px;
            background:var(--sidebar);
            color:var(--sidebarText);
            position:sticky; top:0; height:100vh;
            padding:22px 18px;
        }
        .brand{
            font-weight:800;
            font-size:18px;
            color:#fff;
            display:flex;
            gap:10px;
            align-items:center;
            margin-bottom:18px;
        }
        .navlink{
            display:flex;
            align-items:center;
            gap:10px;
            padding:10px 12px;
            border-radius:14px;
            color:var(--sidebarText);
            text-decoration:none;
            margin-bottom:6px;
            transition:.15s;
        }
        .navlink:hover{
            background:rgba(255,255,255,.08);
            color:#fff;
        }
        .navlink.active{
            background:rgba(79,70,229,.22);
            color:#fff;
        }

        /* Main */
        .main-wrap{ flex:1; padding:22px; }
        .topbar{
            display:flex;
            gap:14px;
            align-items:center;
            justify-content:space-between;
            margin-bottom:16px;
        }
        .soft-card{
            background:var(--card);
            border:1px solid var(--border);
            border-radius:var(--radius);
            box-shadow:var(--shadow);
        }
        .searchbox{
            background:var(--card);
            border:1px solid var(--border);
            border-radius:999px;
            padding:10px 14px;
            width:min(560px, 100%);
            display:flex;
            gap:10px;
            align-items:center;
        }
        .searchbox input{
            border:none;
            outline:none;
            background:transparent;
            width:100%;
            color:var(--text);
        }
        .muted{ color:var(--muted); }

        /* small helpers */
        .stat-icon{
            width:44px; height:44px;
            border-radius:14px;
            display:flex; align-items:center; justify-content:center;
            background:rgba(79,70,229,.12);
            color:var(--accent);
            font-size:20px;
        }

        /* ===== Glass Form + Soft Table UI (Global) ===== */

        .glass-card{
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.12);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            border-radius: 22px;
            box-shadow:
                0 20px 60px rgba(0,0,0,.25),
                0 0 40px rgba(99,102,241,.10);
            overflow: hidden;
        }

        :root[data-theme="light"] .glass-card{
            background: rgba(255,255,255,.75);
            border: 1px solid rgba(15,23,42,.10);
            box-shadow: 0 20px 60px rgba(15,23,42,.10);
        }

        /* Form controls */
        .form-glow .form-control,
        .form-glow .form-select,
        .form-glow .input-group-text,
        .form-glow textarea{
            background: rgba(255,255,255,.06);
            border: 1px solid rgba(255,255,255,.16);
            color: var(--text);
            border-radius: 14px;
            padding: 12px 14px;
        }

        :root[data-theme="light"] .form-glow .form-control,
        :root[data-theme="light"] .form-glow .form-select,
        :root[data-theme="light"] .form-glow .input-group-text,
        :root[data-theme="light"] .form-glow textarea{
            background: rgba(255,255,255,.95);
            border: 1px solid rgba(15,23,42,.12);
        }

        .form-glow .form-control:focus,
        .form-glow .form-select:focus,
        .form-glow textarea:focus{
            outline: none;
            box-shadow: 0 0 0 .22rem rgba(99,102,241,.22);
            border-color: rgba(99,102,241,.55);
        }

        .form-glow label{
            font-weight: 600;
            color: rgba(255,255,255,.85);
        }
        :root[data-theme="light"] .form-glow label{
            color: rgba(15,23,42,.75);
        }

        /* Buttons */
        .btn-glow{
            border: 0;
            border-radius: 14px;
            padding: 10px 14px;
            font-weight: 700;
            color: white;
            background: linear-gradient(135deg, #6366f1, #22d3ee);
            box-shadow: 0 0 22px rgba(99,102,241,.40);
            transition: transform .15s ease, box-shadow .15s ease;
        }
        .btn-glow:hover{
            transform: translateY(-2px);
            box-shadow: 0 0 32px rgba(34,211,238,.50);
        }

        /* ===== Soft Table (pill rows like your screenshot) ===== */
        .table-soft{
            border-collapse: separate;
            border-spacing: 0 12px; /* space between row pills */
        }

        .table-soft thead th{
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: rgba(255,255,255,.70);
            border: 0 !important;
            padding: 10px 14px;
        }
        :root[data-theme="light"] .table-soft thead th{
            color: rgba(15,23,42,.55);
        }

        .table-soft tbody tr{
            background: rgba(255,255,255,.07);
            box-shadow: 0 10px 30px rgba(0,0,0,.10);
        }
        :root[data-theme="light"] .table-soft tbody tr{
            background: rgba(255,255,255,.95);
            box-shadow: 0 10px 30px rgba(15,23,42,.06);
        }

        .table-soft tbody td{
            border: 0 !important;
            padding: 14px 14px;
            vertical-align: middle;
        }

        .table-soft tbody tr td:first-child{
            border-top-left-radius: 16px;
            border-bottom-left-radius: 16px;
        }
        .table-soft tbody tr td:last-child{
            border-top-right-radius: 16px;
            border-bottom-right-radius: 16px;
        }

        .table-soft tbody tr:hover{
            transform: translateY(-1px);
            transition: .12s;
            box-shadow: 0 18px 45px rgba(99,102,241,.16);
        }

        /* ===== Force readable inputs in DARK mode ===== */
        :root[data-theme="dark"] .form-glow .form-control,
        :root[data-theme="dark"] .form-glow .form-select,
        :root[data-theme="dark"] .form-glow textarea,
        :root[data-theme="dark"] .form-glow .input-group-text{
            background: rgba(2, 6, 23, .55) !important;   /* dark glass */
            border: 1px solid rgba(148, 163, 184, .25) !important;
            color: #e5e7eb !important;                   /* readable text */
        }

        :root[data-theme="dark"] .form-glow .input-group-text{
            color: #cbd5e1 !important;
        }

        /* Placeholder color */
        :root[data-theme="dark"] .form-glow .form-control::placeholder,
        :root[data-theme="dark"] .form-glow textarea::placeholder{
            color: rgba(226, 232, 240, .55) !important;
        }

        /* Make label visible in dark mode too */
        :root[data-theme="dark"] .form-glow label{
            color: rgba(226, 232, 240, .85) !important;
        }

        /* ===== FORCE DARK TABLE + GLASS IN DARK MODE ===== */
        :root[data-theme="dark"] .glass-card{
            background: rgba(2, 6, 23, .55) !important;
            border: 1px solid rgba(148, 163, 184, .18) !important;
            box-shadow: 0 20px 60px rgba(0,0,0,.45), 0 0 40px rgba(99,102,241,.12) !important;
            color: #e5e7eb !important;
        }

        /* Make Bootstrap tables/text readable in dark */
        :root[data-theme="dark"] .glass-card .table{
            color: #e5e7eb !important;
        }

        :root[data-theme="dark"] .glass-card .muted{
            color: rgba(226, 232, 240, .65) !important;
        }

        /* Soft table header in dark */
        :root[data-theme="dark"] .table-soft thead th{
            color: rgba(226, 232, 240, .70) !important;
        }

        /* Soft table rows in dark (pill rows) */
        :root[data-theme="dark"] .table-soft tbody tr{
            background: rgba(255,255,255,.06) !important;
            box-shadow: 0 10px 30px rgba(0,0,0,.22) !important;
        }

        :root[data-theme="dark"] .table-soft tbody td{
            color: #e5e7eb !important;
        }

        /* ===== IMPORTANT: Remove Bootstrap white cell backgrounds ===== */
        .table > :not(caption) > * > *{
            background-color: transparent !important;
        }

        /* Extra safety (dark mode) */
        :root[data-theme="dark"] .table{
            --bs-table-bg: transparent !important;
            --bs-table-striped-bg: transparent !important;
            --bs-table-active-bg: transparent !important;
            --bs-table-hover-bg: transparent !important;
            --bs-table-color: #e5e7eb !important;
        }

        /* ===== Aurora Background (Clickable-safe + Strong Motion) ===== */
        body{
            position: relative;
            overflow-x: hidden;
        }

        .aurora-layer{
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;
        }

        .aurora-layer::before,
        .aurora-layer::after{
            content:"";
            position:absolute;
            width: 95vmax;
            height: 95vmax;
            border-radius: 999px;
            filter: blur(55px);
            opacity: .85;
            background:
                radial-gradient(circle at 30% 30%, rgba(99,102,241,.90), transparent 55%),
                radial-gradient(circle at 70% 60%, rgba(34,211,238,.85), transparent 55%),
                radial-gradient(circle at 40% 80%, rgba(168,85,247,.75), transparent 55%);
            animation: auroraMove 5.5s ease-in-out infinite alternate;
        }

        .aurora-layer::after{
            width: 80vmax;
            height: 80vmax;
            top: 25%;
            left: 42%;
            opacity: .70;
            animation-duration: 7s;
        }

        :root[data-theme="light"] .aurora-layer::before,
        :root[data-theme="light"] .aurora-layer::after{
            opacity: .35;
        }

        @keyframes auroraMove{
            0%   { transform: translate(-30%, -24%) rotate(0deg) scale(1); }
            50%  { transform: translate(22%, 14%) rotate(30deg) scale(1.18); }
            100% { transform: translate(-12%, 28%) rotate(-24deg) scale(1.08); }
        }

        @media (prefers-reduced-motion: reduce){
            .aurora-layer::before, .aurora-layer::after{ animation: none; }
        }

        /* ===== Light mode: make aurora visible (brighter) ===== */
        :root[data-theme="light"] .aurora-layer::before,
        :root[data-theme="light"] .aurora-layer::after{
            opacity: .55;                 /* stronger */
            filter: blur(45px);           /* slightly sharper */
        }

        :root[data-theme="light"] .aurora-layer::before{
            background:
                radial-gradient(circle at 25% 30%, rgba(99,102,241,.55), transparent 55%),
                radial-gradient(circle at 70% 55%, rgba(34,211,238,.50), transparent 55%),
                radial-gradient(circle at 40% 80%, rgba(249,115,22,.35), transparent 55%);
        }

        :root[data-theme="light"] .aurora-layer::after{
            background:
                radial-gradient(circle at 30% 30%, rgba(168,85,247,.45), transparent 55%),
                radial-gradient(circle at 75% 65%, rgba(34,211,238,.35), transparent 55%);
        }


    </style>

</head>

    <body>
        {{-- Aurora background ONLY (must stay empty) --}}
        <div class="aurora-layer" aria-hidden="true"></div>

        {{-- Theme script (NOT inside aurora-layer) --}}
        <script>
            (function () {
                const theme = localStorage.getItem('theme') || 'light';
                document.documentElement.dataset.theme = theme;
            })();

            function toggleTheme() {
                const current = document.documentElement.dataset.theme || 'light';
                const next = current === 'light' ? 'dark' : 'light';
                document.documentElement.dataset.theme = next;
                localStorage.setItem('theme', next);
            }
        </script>

        <div class="app-shell">
            @include('partials.sidebar')

            <main class="main-wrap">
                <div class="topbar">
                    <form method="GET" class="searchbox soft-card">
                            <i class="bi bi-search muted"></i>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search in this page..."
                            />
                        </form>

                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-sm btn-outline-secondary" type="button" onclick="toggleTheme()">
                            <i class="bi bi-moon-stars"></i>
                        </button>

                        <div class="dropdown">
                            <button class="btn btn-sm btn-primary dropdown-toggle" data-bs-toggle="dropdown" type="button">
                                <i class="bi bi-person-circle me-1"></i>
                                {{ auth()->user()->name ?? 'Staff' }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><span class="dropdown-item-text muted">{{ auth()->user()->email ?? '' }}</span></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit">
                                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                @isset($header)
                    <div class="mb-3">
                        <h4 class="mb-0">{{ $header }}</h4>
                    </div>
                @endisset

                {{ $slot }}
            </main>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>


</html>
