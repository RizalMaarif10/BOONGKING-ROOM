@extends('layouts.admin')

@section('page_title', 'Dashboard')
@section('page_subtitle', 'Ringkasan aktivitas sistem booking ruangan')

@section('content')

    {{-- ── STAT CARDS ── --}}
    <div class="row g-3 mb-4">

        <div class="col-sm-6 col-xl-3">
            <div class="card h-100" style="border-left:4px solid #3b82f6 !important;">
                <div class="card-body d-flex align-items-center gap-3 py-3">
                    <div
                        style="width:46px;height:46px;border-radius:12px;background:linear-gradient(135deg,#3b82f6,#1d4ed8);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi bi-building text-white" style="font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div
                            style="font-size:0.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;">
                            Total Ruangan</div>
                        <div style="font-size:1.8rem;font-weight:800;color:#0f172a;line-height:1.1;">{{ $totalRooms }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card h-100" style="border-left:4px solid #22c55e !important;">
                <div class="card-body d-flex align-items-center gap-3 py-3">
                    <div
                        style="width:46px;height:46px;border-radius:12px;background:linear-gradient(135deg,#22c55e,#15803d);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi bi-people-fill text-white" style="font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div
                            style="font-size:0.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;">
                            Total User</div>
                        <div style="font-size:1.8rem;font-weight:800;color:#0f172a;line-height:1.1;">{{ $totalUsers }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card h-100" style="border-left:4px solid #8b5cf6 !important;">
                <div class="card-body d-flex align-items-center gap-3 py-3">
                    <div
                        style="width:46px;height:46px;border-radius:12px;background:linear-gradient(135deg,#8b5cf6,#6d28d9);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi bi-calendar2-check text-white" style="font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div
                            style="font-size:0.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;">
                            Total Booking</div>
                        <div style="font-size:1.8rem;font-weight:800;color:#0f172a;line-height:1.1;">{{ $totalBookings }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="card h-100" style="border-left:4px solid #f59e0b !important;">
                <div class="card-body d-flex align-items-center gap-3 py-3">
                    <div
                        style="width:46px;height:46px;border-radius:12px;background:linear-gradient(135deg,#f59e0b,#d97706);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="bi bi-hourglass-split text-white" style="font-size:1.1rem;"></i>
                    </div>
                    <div>
                        <div
                            style="font-size:0.72rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.06em;">
                            Pending Approval</div>
                        <div style="font-size:1.8rem;font-weight:800;color:#0f172a;line-height:1.1;">{{ $pending }}
                        </div>
                    </div>
                    @if ($pending > 0)
                        <a href="/admin/bookings?status=pending"
                            class="ms-auto d-flex align-items-center justify-content-center"
                            style="width:28px;height:28px;border-radius:8px;background:#fef3c7;color:#d97706;flex-shrink:0;text-decoration:none;font-size:0.75rem;">
                            <i class="bi bi-arrow-right-short" style="font-size:1.1rem;"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- ── MAIN ROW ── --}}
    <div class="row g-3">

        {{-- Booking Terbaru --}}
        <div class="col-xl-7">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div
                            style="width:4px;height:18px;background:linear-gradient(180deg,#3b82f6,#6366f1);border-radius:999px;">
                        </div>
                        Booking Terbaru
                    </div>
                    <a href="/admin/bookings" style="font-size:0.75rem;font-weight:600;color:#3b82f6;text-decoration:none;">
                        Lihat Semua <i class="bi bi-arrow-right-short"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Ruangan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestBookings as $booking)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div
                                                style="width:30px;height:30px;border-radius:8px;background:linear-gradient(135deg,#3b82f6,#1d4ed8);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.75rem;flex-shrink:0;">
                                                {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                                            </div>
                                            <span style="font-weight:600;color:#1e293b;">{{ $booking->user->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span style="color:#334155;">{{ $booking->room->nama_ruangan }}</span>
                                    </td>
                                    <td>
                                        <span style="color:#64748b;font-size:0.82rem;">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($booking->status == 'pending')
                                            <span class="badge-pending">⏳ Pending</span>
                                        @elseif($booking->status == 'approved')
                                            <span class="badge-approved">✓ Approved</span>
                                        @elseif($booking->status == 'rejected')
                                            <span class="badge-rejected">✕ Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <i class="bi bi-calendar2-x d-block mb-2" style="font-size:2rem;color:#cbd5e1;"></i>
                                        <span style="color:#94a3b8;font-size:0.85rem;">Belum ada data booking</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Statistik + Quick Actions --}}
        <div class="col-xl-5 d-flex flex-column gap-3">

            {{-- Donut Chart --}}
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <div
                        style="width:4px;height:18px;background:linear-gradient(180deg,#8b5cf6,#6366f1);border-radius:999px;">
                    </div>
                    Statistik Booking
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center gap-3">
                        <div style="flex:0 0 160px;height:160px;">
                            <canvas id="bookingChart"></canvas>
                        </div>
                        <div class="d-flex flex-column gap-2 flex-grow-1">
                            <div class="d-flex align-items-center justify-content-between p-2 rounded-3"
                                style="background:#fef3c7;">
                                <div class="d-flex align-items-center gap-2">
                                    <span
                                        style="width:10px;height:10px;border-radius:50%;background:#f59e0b;display:inline-block;"></span>
                                    <span style="font-size:0.82rem;font-weight:600;color:#92400e;">Pending</span>
                                </div>
                                <strong
                                    style="font-size:0.95rem;color:#92400e;">{{ \App\Models\Booking::where('status', 'pending')->count() }}</strong>
                            </div>
                            <div class="d-flex align-items-center justify-content-between p-2 rounded-3"
                                style="background:#dcfce7;">
                                <div class="d-flex align-items-center gap-2">
                                    <span
                                        style="width:10px;height:10px;border-radius:50%;background:#22c55e;display:inline-block;"></span>
                                    <span style="font-size:0.82rem;font-weight:600;color:#15803d;">Approved</span>
                                </div>
                                <strong
                                    style="font-size:0.95rem;color:#15803d;">{{ \App\Models\Booking::where('status', 'approved')->count() }}</strong>
                            </div>
                            <div class="d-flex align-items-center justify-content-between p-2 rounded-3"
                                style="background:#fee2e2;">
                                <div class="d-flex align-items-center gap-2">
                                    <span
                                        style="width:10px;height:10px;border-radius:50%;background:#ef4444;display:inline-block;"></span>
                                    <span style="font-size:0.82rem;font-weight:600;color:#991b1b;">Rejected</span>
                                </div>
                                <strong
                                    style="font-size:0.95rem;color:#991b1b;">{{ \App\Models\Booking::where('status', 'rejected')->count() }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Access --}}
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <div
                        style="width:4px;height:18px;background:linear-gradient(180deg,#22c55e,#16a34a);border-radius:999px;">
                    </div>
                    Akses Cepat
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="/admin/rooms/create"
                                class="d-flex align-items-center gap-2 p-3 rounded-3 text-decoration-none"
                                style="background:#eff6ff;border:1px solid #dbeafe;transition:background 0.2s;"
                                onmouseover="this.style.background='#dbeafe'"
                                onmouseout="this.style.background='#eff6ff'">
                                <i class="bi bi-plus-circle-fill" style="color:#3b82f6;font-size:1.1rem;"></i>
                                <span style="font-size:0.8rem;font-weight:700;color:#1d4ed8;">Tambah Ruangan</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="/admin/bookings?status=pending"
                                class="d-flex align-items-center gap-2 p-3 rounded-3 text-decoration-none"
                                style="background:#fefce8;border:1px solid #fef08a;transition:background 0.2s;"
                                onmouseover="this.style.background='#fef9c3'"
                                onmouseout="this.style.background='#fefce8'">
                                <i class="bi bi-clock-history" style="color:#ca8a04;font-size:1.1rem;"></i>
                                <span style="font-size:0.8rem;font-weight:700;color:#854d0e;">Review Booking</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="/admin/users"
                                class="d-flex align-items-center gap-2 p-3 rounded-3 text-decoration-none"
                                style="background:#f0fdf4;border:1px solid #bbf7d0;transition:background 0.2s;"
                                onmouseover="this.style.background='#dcfce7'"
                                onmouseout="this.style.background='#f0fdf4'">
                                <i class="bi bi-person-badge-fill" style="color:#16a34a;font-size:1.1rem;"></i>
                                <span style="font-size:0.8rem;font-weight:700;color:#15803d;">Kelola User</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="/admin/bookings"
                                class="d-flex align-items-center gap-2 p-3 rounded-3 text-decoration-none"
                                style="background:#faf5ff;border:1px solid #e9d5ff;transition:background 0.2s;"
                                onmouseover="this.style.background='#f3e8ff'"
                                onmouseout="this.style.background='#faf5ff'">
                                <i class="bi bi-list-ul" style="color:#7c3aed;font-size:1.1rem;"></i>
                                <span style="font-size:0.8rem;font-weight:700;color:#6d28d9;">Semua Booking</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('bookingChart'), {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Approved', 'Rejected'],
                datasets: [{
                    data: [
                        {{ \App\Models\Booking::where('status', 'pending')->count() }},
                        {{ \App\Models\Booking::where('status', 'approved')->count() }},
                        {{ \App\Models\Booking::where('status', 'rejected')->count() }}
                    ],
                    backgroundColor: ['#f59e0b', '#22c55e', '#ef4444'],
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                cutout: '72%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ${ctx.label}: ${ctx.parsed}`
                        }
                    }
                },
                animation: {
                    animateScale: true
                }
            }
        });
    </script>

@endsection
