<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Booking Ruangan')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: #f1f5f9;
        }

        /* ── NAVBAR ── */
        .user-navbar {
            background: linear-gradient(135deg, #0f172a, #1e3a5f);
            padding: 0 28px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.2);
        }

        .user-navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .user-navbar-brand-icon {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-navbar-brand-text {
            color: white;
            font-weight: 700;
            font-size: 0.95rem;
        }

        .user-nav-link {
            display: flex;
            align-items: center;
            gap: 7px;
            color: rgba(255, 255, 255, 0.65);
            text-decoration: none;
            font-size: 0.84rem;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
            transition: all 0.2s;
            border: none;
            background: transparent;
            cursor: pointer;
        }

        .user-nav-link:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
        }

        .user-nav-link.active {
            background: rgba(59, 130, 246, 0.2);
            color: #93c5fd;
        }

        /* ── CARDS ── */
        .card {
            border: 1px solid #e2e8f0 !important;
            border-radius: 16px !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04) !important;
        }

        .card-header {
            background: white !important;
            border-bottom: 1px solid #f1f5f9 !important;
            border-radius: 16px 16px 0 0 !important;
            padding: 16px 20px !important;
            font-weight: 700;
            font-size: 0.9rem;
            color: #0f172a;
        }

        /* ── TABLE ── */
        .table {
            font-size: 0.87rem;
        }

        .table thead th {
            background: #f8fafc;
            color: #64748b;
            font-weight: 700;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: 12px 16px;
        }

        .table tbody td {
            padding: 13px 16px;
            vertical-align: middle;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        .table tbody tr:hover td {
            background: #f8fafc;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ── STATUS BADGES ── */
        .badge-pending {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.72rem;
            display: inline-block;
        }

        .badge-approved {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.72rem;
            display: inline-block;
        }

        .badge-rejected {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.72rem;
            display: inline-block;
        }

        .page-body {
            padding: 28px;
            max-width: 1100px;
            margin: 0 auto;
        }
    </style>
</head>

<body>

    {{-- ── NAVBAR ── --}}
    @php
        $currentPath = request()->path();
        $isDashboard = $currentPath === 'rooms';
        $isBooking = $currentPath === 'booking/create';
        $isRiwayat = $currentPath === 'booking';
        $isJadwal = str_starts_with($currentPath, 'schedule');
    @endphp

    <nav class="user-navbar">
        {{-- Brand --}}
        <a href="{{ route('rooms') }}" class="user-navbar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Kampus"
                style="height:36px;width:auto;border-radius:6px;">
            <span class="user-navbar-brand-text">SMK NEGERI 6 PURWOREJO</span>
        </a>

        {{-- Nav Links --}}
        <div class="d-flex align-items-center gap-1">

            {{-- Dashboard --}}
            <a href="{{ route('rooms') }}" class="user-nav-link {{ $isDashboard ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i>
                <span class="d-none d-md-inline">Dashboard</span>
            </a>

            {{-- Booking --}}
            <a href="{{ route('booking.create') }}" class="user-nav-link {{ $isBooking ? 'active' : '' }}">
                <i class="bi bi-calendar2-plus"></i>
                <span class="d-none d-md-inline">Booking</span>
            </a>

            {{-- Riwayat --}}
            <a href="{{ route('booking.index') }}" class="user-nav-link {{ $isRiwayat ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span class="d-none d-md-inline">Riwayat</span>
            </a>

            {{-- Jadwal --}}
            <a href="{{ route('schedule') }}" class="user-nav-link {{ $isJadwal ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i>
                <span class="d-none d-md-inline">Jadwal</span>
            </a>

        </div>

        {{-- User Info + Logout --}}
        <div class="d-flex align-items-center gap-3">
            <div class="d-none d-md-flex align-items-center gap-2">
                <div
                    style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#3b82f6,#1d4ed8);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.75rem;">
                    {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                </div>
                <span style="color:rgba(255,255,255,0.75);font-size:0.82rem;font-weight:600;">
                    {{ auth()->user()->name ?? 'User' }}
                </span>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button type="submit" class="user-nav-link"
                    style="background:rgba(239,68,68,0.15);color:#fca5a5;border:1px solid rgba(239,68,68,0.25);">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </nav>

    <div class="page-body">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
