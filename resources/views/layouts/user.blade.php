<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Booking Ruangan')</title>
     {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }

        body {
            background: #f1f5f9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            /* ruang untuk bottom nav di mobile */
            padding-bottom: 0;
        }

        /* ── NAVBAR (desktop) ── */
        .user-navbar {
            background: linear-gradient(135deg, #0f172a, #1e3a5f);
            padding: 0 28px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0; z-index: 100;
            box-shadow: 0 2px 16px rgba(0,0,0,0.2);
        }

        .user-navbar-brand {
            display: flex; align-items: center; gap: 10px;
            text-decoration: none;
        }

        .user-navbar-brand-icon {
            width: 34px; height: 34px;
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
        }

        .user-navbar-brand-text { color: white; font-weight: 700; font-size: 0.95rem; }

        .user-nav-link {
            display: flex; align-items: center; gap: 7px;
            color: rgba(255,255,255,0.65);
            text-decoration: none;
            font-size: 0.84rem; font-weight: 600;
            padding: 6px 12px;
            border-radius: 8px;
            transition: all 0.2s;
            border: none; background: transparent; cursor: pointer;
        }

        .user-nav-link:hover { background: rgba(255,255,255,0.08); color: white; }
        .user-nav-link.active { background: rgba(59,130,246,0.2); color: #93c5fd; }

        /* ── CARDS ── */
        .card { border: 1px solid #e2e8f0 !important; border-radius: 16px !important; box-shadow: 0 2px 12px rgba(0,0,0,0.04) !important; }
        .card-header { background: white !important; border-bottom: 1px solid #f1f5f9 !important; border-radius: 16px 16px 0 0 !important; padding: 16px 20px !important; font-weight: 700; font-size: 0.9rem; color: #0f172a; }

        /* ── TABLE ── */
        .table { font-size: 0.87rem; }
        .table thead th { background: #f8fafc; color: #64748b; font-weight: 700; font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.06em; border-bottom: 1px solid #e2e8f0 !important; padding: 12px 16px; }
        .table tbody td { padding: 13px 16px; vertical-align: middle; color: #334155; border-bottom: 1px solid #f1f5f9; }
        .table tbody tr:hover td { background: #f8fafc; }
        .table tbody tr:last-child td { border-bottom: none; }

        /* ── STATUS BADGES ── */
        .badge-pending { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; font-weight: 700; padding: 4px 10px; border-radius: 999px; font-size: 0.72rem; display: inline-block; }
        .badge-approved { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; font-weight: 700; padding: 4px 10px; border-radius: 999px; font-size: 0.72rem; display: inline-block; }
        .badge-rejected { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; font-weight: 700; padding: 4px 10px; border-radius: 999px; font-size: 0.72rem; display: inline-block; }

        .page-body {
            padding: 28px;
            max-width: 1100px;
            margin: 0 auto;
            flex: 1;
            width: 100%;
        }

        /* ── FOOTER ── */
        .user-footer {
            background: linear-gradient(135deg, #0f172a, #1e3a5f);
            color: rgba(255,255,255,0.45);
            text-align: center;
            font-size: 0.75rem;
            font-weight: 500;
            padding: 14px 28px;
        }

        .user-footer span { color: rgba(255,255,255,0.75); font-weight: 600; }

        /* ── BOTTOM NAV (mobile only) ── */
        .bottom-nav {
            display: none;
            position: fixed;
            bottom: 0; left: 0; right: 0;
            background: linear-gradient(135deg, #0f172a, #1e3a5f);
            border-top: 1px solid rgba(255,255,255,0.08);
            z-index: 100;
            padding: 0;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.25);
        }

        .bottom-nav-inner {
            display: flex;
            align-items: stretch;
            height: 60px;
        }

        .bottom-nav-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            text-decoration: none;
            color: rgba(255,255,255,0.5);
            font-size: 0.62rem;
            font-weight: 600;
            transition: all 0.2s;
            border: none;
            background: transparent;
            cursor: pointer;
            padding: 8px 4px;
        }

        .bottom-nav-item i { font-size: 1.25rem; line-height: 1; }

        .bottom-nav-item.active {
            color: #93c5fd;
        }

        .bottom-nav-item.active i {
            color: #3b82f6;
        }

        .bottom-nav-item:hover { color: white; }

        .bottom-nav-logout {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            color: #fca5a5;
            font-size: 0.62rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            background: transparent;
            padding: 8px 4px;
        }

        .bottom-nav-logout i { font-size: 1.25rem; line-height: 1; }

        /* ── MOBILE RESPONSIVE ── */
        @media (max-width: 768px) {
            /* Sembunyikan nav links & user info di navbar atas */
            .navbar-desktop-links,
            .navbar-desktop-user {
                display: none !important;
            }

            /* Tampilkan bottom nav */
            .bottom-nav { display: block; }

            /* Beri ruang agar konten tidak tertutup bottom nav */
            body { padding-bottom: 60px; }

            .page-body { padding: 16px; }

            .user-footer { display: none; }

            .user-navbar {
                padding: 0 16px;
                height: 54px;
            }

            .user-navbar-brand-text {
                font-size: 0.8rem;
            }
        }
    </style>
</head>

<body>

    {{-- ── NAVBAR ── --}}
    @php
        $currentPath = request()->path();
        $isDashboard = $currentPath === 'rooms';
        $isBooking   = $currentPath === 'booking/create';
        $isRiwayat   = $currentPath === 'booking';
        $isJadwal    = str_starts_with($currentPath, 'schedule');
    @endphp

    <nav class="user-navbar">
        {{-- Brand --}}
        <a href="{{ route('rooms') }}" class="user-navbar-brand">
            <div class="user-navbar-brand-icon" style="background:transparent;">
                @if (file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width:34px;height:34px;object-fit:contain;">
                @else
                    <i class="bi bi-building-fill text-white" style="font-size:0.9rem;"></i>
                @endif
            </div>
            <span class="user-navbar-brand-text">SMK NEGERI 6 PURWOREJO</span>
        </a>

        {{-- Nav Links (desktop) --}}
        <div class="d-flex align-items-center gap-1 navbar-desktop-links">
            <a href="{{ route('rooms') }}" class="user-nav-link {{ $isDashboard ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('booking.create') }}" class="user-nav-link {{ $isBooking ? 'active' : '' }}">
                <i class="bi bi-calendar2-plus"></i>
                <span>Booking</span>
            </a>
            <a href="{{ route('booking.index') }}" class="user-nav-link {{ $isRiwayat ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Riwayat</span>
            </a>
            <a href="{{ route('schedule') }}" class="user-nav-link {{ $isJadwal ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i>
                <span>Jadwal</span>
            </a>
        </div>

        {{-- User Info + Logout (desktop) --}}
        <div class="d-flex align-items-center gap-3 navbar-desktop-user">
            <div class="d-flex align-items-center gap-2">
                <div style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#3b82f6,#1d4ed8);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.75rem;">
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

        {{-- User avatar only (mobile, kanan navbar) --}}
        <div class="d-flex d-md-none align-items-center" style="margin-left:auto;">
            <div style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#3b82f6,#1d4ed8);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.75rem;">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
        </div>
    </nav>

    {{-- ── KONTEN ── --}}
    <div class="page-body">
        @yield('content')
    </div>

    {{-- ── FOOTER (desktop) ── --}}
    <footer class="user-footer">
        &copy; {{ date('Y') }} <span>SMK Negeri 6 Purworejo</span> &mdash; Sistem Booking Ruangan. All rights reserved.
    </footer>

    {{-- ── BOTTOM NAV (mobile) ── --}}
    <nav class="bottom-nav">
        <div class="bottom-nav-inner">
            <a href="{{ route('rooms') }}" class="bottom-nav-item {{ $isDashboard ? 'active' : '' }}">
                <i class="bi bi-grid-1x2{{ $isDashboard ? '-fill' : '' }}"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('booking.create') }}" class="bottom-nav-item {{ $isBooking ? 'active' : '' }}">
                <i class="bi bi-calendar2-plus{{ $isBooking ? '-fill' : '' }}"></i>
                <span>Booking</span>
            </a>
            <a href="{{ route('booking.index') }}" class="bottom-nav-item {{ $isRiwayat ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Riwayat</span>
            </a>
            <a href="{{ route('schedule') }}" class="bottom-nav-item {{ $isJadwal ? 'active' : '' }}">
                <i class="bi bi-calendar3{{ $isJadwal ? '-fill' : '' }}"></i>
                <span>Jadwal</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="m-0" style="flex:1;display:flex;">
                @csrf
                <button type="submit" class="bottom-nav-logout">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
