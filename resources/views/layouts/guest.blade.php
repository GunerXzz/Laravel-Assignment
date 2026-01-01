<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Hotel') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root[data-theme="light"]{
            --bg:#f5f7ff; --card:#fff; --text:#0f172a; --muted:#64748b; --border:#e5e7eb;
            --accent:#4f46e5; --shadow: 0 10px 30px rgba(15,23,42,.08); --radius:18px;
        }
        :root[data-theme="dark"]{
            --bg:#070d1c; --card:#0f1a33; --text:#e5e7eb; --muted:#94a3b8; --border:#1f2a44;
            --accent:#8b5cf6; --shadow: 0 10px 30px rgba(0,0,0,.35); --radius:18px;
        }
        body{ background:var(--bg); color:var(--text); }
        .soft-card{
            background:var(--card);
            border:1px solid var(--border);
            border-radius:var(--radius);
            box-shadow:var(--shadow);
        }
        .muted{ color:var(--muted); }

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


    </style>
</head>
<body>
    <div class="aurora-layer" aria-hidden="true"></div>
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

        <div class="min-vh-100 d-flex align-items-center">
            <div class="container">
                {{ $slot }}
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
