<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') — Booking Ruangan</title>
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

        /* ── SIDEBAR ── */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 22px 20px 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .sidebar-brand-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
        }

        .sidebar-brand-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .sidebar-brand-text {
            color: white;
            font-weight: 700;
            font-size: 0.92rem;
            line-height: 1.2;
        }

        .sidebar-brand-sub {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.7rem;
            font-weight: 500;
        }

        .sidebar-section {
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.3);
            padding: 16px 20px 6px;
        }

        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            margin: 2px 10px;
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.6);
            text-decoration: none;
            font-size: 0.87rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .sidebar nav a i {
            font-size: 1rem;
        }

        .sidebar nav a:hover {
            background: rgba(255, 255, 255, 0.08);
            color: white;
        }

        .sidebar nav a.active {
            background: rgba(59, 130, 246, 0.2);
            color: #93c5fd;
            font-weight: 700;
        }

        .sidebar nav a.active i {
            color: #3b82f6;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.07);
        }

        /* ── MAIN ── */
        .main-content {
            margin-left: 250px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .topbar-title {
            font-weight: 700;
            color: #0f172a;
            font-size: 0.97rem;
        }

        .topbar-sub {
            color: #94a3b8;
            font-size: 0.76rem;
        }

        .page-body {
            padding: 24px 28px;
            flex: 1;
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

        /* ── STATUS BADGES ── */
        .badge-pending {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fde68a;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.72rem;
        }

        .badge-approved {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.72rem;
        }

        .badge-rejected {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.72rem;
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

        /* scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #1e293b;
        }

        ::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 99px;
        }
    </style>
</head>

<body>

    {{-- ── SIDEBAR ── --}}
    <aside class="sidebar">

        {{-- Brand --}}
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                @if (file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                @else
                    <i class="bi bi-building-fill text-white" style="font-size:1rem;"></i>
                @endif
            </div>
            <div>
                <div class="sidebar-brand-text">SMK NEGERI 6 PURWOREJO</div>
                <div class="sidebar-brand-sub">Admin Panel</div>
            </div>
        </div>

        {{-- Menu --}}
        <div class="sidebar-section">Menu Utama</div>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
            <a href="{{ route('admin.rooms.index') }}" class="{{ request()->is('admin/rooms*') ? 'active' : '' }}">
                <i class="bi bi-building"></i> Ruangan
            </a>
            <a href="{{ route('admin.jenis-ruangan.index') }}"
                class="{{ request()->is('admin/jenis-ruangan*') ? 'active' : '' }}">
                <i class="bi bi-tags"></i> Jenis Ruangan
            </a>
            <a href="{{ route('admin.bookings') }}" class="{{ request()->is('admin/bookings*') ? 'active' : '' }}">
                <i class="bi bi-calendar2-check"></i> Booking
            </a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->is('admin/users*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i> Users
            </a>
        </nav>

        {{-- Footer --}}
        <div class="sidebar-footer">
            <div class="d-flex align-items-center gap-2 mb-3 px-1">
                <div
                    style="width:34px;height:34px;border-radius:10px;background:rgba(255,255,255,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="bi bi-person-fill text-white" style="font-size:0.9rem;"></i>
                </div>
                <div style="min-width:0;">
                    <div
                        style="color:white;font-size:0.82rem;font-weight:600;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        {{ auth()->user()->name ?? 'Admin' }}
                    </div>
                    <div
                        style="color:rgba(255,255,255,0.35);font-size:0.68rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        {{ auth()->user()->email ?? '' }}
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm w-100 d-flex align-items-center justify-content-center gap-2"
                    style="background:rgba(239,68,68,0.15);color:#fca5a5;border:1px solid rgba(239,68,68,0.3);border-radius:10px;font-size:0.8rem;font-weight:600;padding:8px;">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- ── MAIN ── --}}
    <div class="main-content">
        <div class="topbar">
            <div>
                <div class="topbar-title">@yield('page_title', 'Dashboard')</div>
                <div class="topbar-sub">@yield('page_subtitle', 'Selamat datang di panel administrator')</div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="d-none d-md-flex align-items-center gap-2 px-3 py-2 rounded-3"
                    style="background:#f8fafc;border:1px solid #e2e8f0;font-size:0.78rem;color:#64748b;">
                    <i class="bi bi-calendar3"></i>
                    {{ now()->translatedFormat('d F Y') }}
                </span>
            </div>
        </div>

        <div class="page-body">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
