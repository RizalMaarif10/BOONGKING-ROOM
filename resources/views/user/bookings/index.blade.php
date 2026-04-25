@extends('layouts.user')

@section('title', 'Riwayat Booking')

@section('content')

    {{-- ── HEADER ── --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h5 class="fw-bold mb-1" style="color:#0f172a;font-size:1.1rem;">Riwayat Booking Saya</h5>
            <p class="mb-0" style="color:#94a3b8;font-size:0.83rem;">Semua pengajuan booking yang pernah kamu lakukan</p>
        </div>
        <a href="{{ route('booking.create') }}" class="d-inline-flex align-items-center gap-2"
            style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);color:white;border:none;border-radius:10px;font-weight:700;font-size:0.82rem;padding:9px 18px;text-decoration:none;box-shadow:0 4px 12px rgba(59,130,246,0.3);">
            <i class="bi bi-calendar2-plus"></i> Booking Baru
        </a>
    </div>

    {{-- ── SUMMARY CARDS ── --}}
    <div class="row g-3 mb-4">
        @php
            $total = $allBookings->count();
            $pending = $allBookings->where('status', 'pending')->count();
            $approved = $allBookings->where('status', 'approved')->count();
            $rejected = $allBookings->where('status', 'rejected')->count();
        @endphp

        @foreach ([['label' => 'Total', 'val' => $total, 'icon' => 'calendar2-check', 'bg' => '#eff6ff', 'color' => '#1d4ed8', 'border' => '#bfdbfe'], ['label' => 'Pending', 'val' => $pending, 'icon' => 'hourglass-split', 'bg' => '#fefce8', 'color' => '#a16207', 'border' => '#fef08a'], ['label' => 'Approved', 'val' => $approved, 'icon' => 'check-circle-fill', 'bg' => '#f0fdf4', 'color' => '#15803d', 'border' => '#bbf7d0'], ['label' => 'Rejected', 'val' => $rejected, 'icon' => 'x-circle-fill', 'bg' => '#fff1f2', 'color' => '#be123c', 'border' => '#fecdd3']] as $s)
            <div class="col-6 col-md-3">
                <div class="card h-100" style="border:1px solid {{ $s['border'] }} !important;">
                    <div class="card-body d-flex align-items-center gap-3 py-3"
                        style="background:{{ $s['bg'] }};border-radius:16px;">
                        <div
                            style="width:40px;height:40px;border-radius:10px;background:{{ $s['color'] }};display:flex;align-items:center;justify-content:center;flex-shrink:0;opacity:0.9;">
                            <i class="bi bi-{{ $s['icon'] }} text-white" style="font-size:1rem;"></i>
                        </div>
                        <div>
                            <div
                                style="font-size:0.68rem;font-weight:700;color:{{ $s['color'] }};text-transform:uppercase;opacity:0.7;">
                                {{ $s['label'] }}
                            </div>
                            <div style="font-size:1.6rem;font-weight:800;color:{{ $s['color'] }};line-height:1.1;">
                                {{ $s['val'] }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ── FILTER TABS ── --}}
    @php $sf = request('status', 'all'); @endphp
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            @foreach (['all' => 'Semua', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $val => $label)
                <a href="?status={{ $val }}"
                    class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-3 text-decoration-none"
                    style="font-size:0.8rem;font-weight:700;
                        background:{{ $sf == $val ? '#1e293b' : '#f1f5f9' }};
                        color:{{ $sf == $val ? 'white' : '#64748b' }};
                        border:1px solid {{ $sf == $val ? '#1e293b' : '#e2e8f0' }};">
                    @if ($val == 'pending')
                        <span
                            style="width:7px;height:7px;border-radius:50%;background:#f59e0b;display:inline-block;"></span>
                    @elseif ($val == 'approved')
                        <span
                            style="width:7px;height:7px;border-radius:50%;background:#22c55e;display:inline-block;"></span>
                    @elseif ($val == 'rejected')
                        <span
                            style="width:7px;height:7px;border-radius:50%;background:#ef4444;display:inline-block;"></span>
                    @endif
                    {{ $label }}
                </a>
            @endforeach
        </div>
        <span style="font-size:0.8rem;color:#94a3b8;font-weight:600;">
            {{ $bookings->count() }} data ditemukan
        </span>
    </div>

    {{-- ── ALERT ── --}}
    @if (session('success'))
        <div class="d-flex align-items-center gap-2 p-3 mb-3 rounded-3"
            style="background:#dcfce7;border:1px solid #bbf7d0;color:#15803d;font-size:0.85rem;font-weight:600;">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    {{-- ── TABEL RIWAYAT ── --}}
    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Ruangan</th>
                        <th>Jadwal</th>
                        <th class="d-none d-md-table-cell">Keperluan</th>
                        <th>Status</th>
                        <th class="d-none d-lg-table-cell">Diajukan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bookings as $booking)
                        <tr>
                            {{-- Ruangan --}}
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div
                                        style="width:34px;height:34px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="bi bi-building" style="font-size:0.8rem;color:#3b82f6;"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight:700;color:#1e293b;font-size:0.87rem;">
                                            {{ $booking->room->nama_ruangan }}
                                        </div>
                                        @if ($booking->room->jenisRuangan)
                                            <div style="font-size:0.7rem;color:#94a3b8;font-weight:600;">
                                                {{ $booking->room->jenisRuangan->nama }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            {{-- Jadwal --}}
                            <td>
                                <div style="font-weight:600;color:#334155;font-size:0.84rem;">
                                    <i class="bi bi-calendar3 me-1" style="color:#94a3b8;"></i>
                                    {{ \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') }}
                                </div>
                                <div style="color:#64748b;font-size:0.78rem;margin-top:2px;">
                                    <i class="bi bi-clock me-1" style="color:#94a3b8;"></i>
                                    {{ $booking->jam_mulai }} – {{ $booking->jam_selesai }}
                                </div>
                            </td>

                            {{-- Keperluan --}}
                            <td class="d-none d-md-table-cell">
                                <span style="color:#64748b;font-size:0.82rem;">
                                    {{ Str::limit($booking->keperluan, 45) }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td>
                                @if ($booking->status == 'pending')
                                    <span class="badge-pending">⏳ Pending</span>
                                @elseif ($booking->status == 'approved')
                                    <span class="badge-approved">✓ Approved</span>
                                @elseif ($booking->status == 'rejected')
                                    <span class="badge-rejected">✕ Rejected</span>
                                @endif
                            </td>

                            {{-- Diajukan --}}
                            <td class="d-none d-lg-table-cell">
                                <div style="color:#64748b;font-size:0.78rem;">
                                    {{ $booking->created_at->format('d M Y') }}
                                </div>
                                <div style="color:#94a3b8;font-size:0.72rem;">
                                    {{ $booking->created_at->diffForHumans() }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div
                                    style="width:56px;height:56px;border-radius:14px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                                    <i class="bi bi-calendar2-x" style="font-size:1.5rem;color:#cbd5e1;"></i>
                                </div>
                                @if ($sf != 'all')
                                    <p style="color:#94a3b8;font-size:0.85rem;margin-bottom:8px;">
                                        Tidak ada booking dengan status <strong>{{ $sf }}</strong>
                                    </p>
                                    <a href="{{ route('booking.index') }}"
                                        style="font-size:0.82rem;font-weight:700;color:#3b82f6;text-decoration:none;">
                                        Tampilkan Semua
                                    </a>
                                @else
                                    <p style="color:#94a3b8;font-size:0.85rem;margin-bottom:8px;">
                                        Belum ada riwayat booking
                                    </p>
                                    <a href="{{ route('booking.create') }}"
                                        style="font-size:0.82rem;font-weight:700;color:#3b82f6;text-decoration:none;">
                                        + Buat Booking Pertama
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if (method_exists($bookings, 'hasPages') && $bookings->hasPages())
            <div class="card-footer bg-white border-top-0 py-3">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>

@endsection
