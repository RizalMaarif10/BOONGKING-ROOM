@extends('layouts.admin')

@section('page_title', 'Manajemen Booking')
@section('page_subtitle', 'Review dan kelola semua permintaan booking ruangan')

@section('content')

    {{-- Filter Status --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            @php $status = request('status', 'all'); @endphp
            @foreach (['all' => 'Semua', 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $val => $label)
                <a href="?status={{ $val }}"
                    class="d-inline-flex align-items-center gap-1 px-3 py-2 rounded-3 text-decoration-none"
                    style="font-size:0.8rem;font-weight:700;
                background:{{ $status == $val ? '#1e293b' : '#f1f5f9' }};
                color:{{ $status == $val ? 'white' : '#64748b' }};
                border:1px solid {{ $status == $val ? '#1e293b' : '#e2e8f0' }};">
                    @if ($val == 'pending')
                        <span style="width:7px;height:7px;border-radius:50%;background:#f59e0b;display:inline-block;"></span>
                    @elseif($val == 'approved')
                        <span style="width:7px;height:7px;border-radius:50%;background:#22c55e;display:inline-block;"></span>
                    @elseif($val == 'rejected')
                        <span style="width:7px;height:7px;border-radius:50%;background:#ef4444;display:inline-block;"></span>
                    @endif
                    {{ $label }}
                </a>
            @endforeach
        </div>
        <span style="font-size:0.8rem;color:#94a3b8;font-weight:600;">
            {{ $bookings->count() }} data ditemukan
        </span>
    </div>

    @if (session('success'))
        <div class="d-flex align-items-center gap-2 p-3 mb-4 rounded-3"
            style="background:#dcfce7;border:1px solid #bbf7d0;color:#15803d;font-size:0.85rem;font-weight:600;">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Pemohon</th>
                        <th>Ruangan</th>
                        <th>Jadwal</th>
                        <th class="d-none d-xl-table-cell">Keperluan</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            {{-- Pemohon --}}
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div
                                        style="width:34px;height:34px;border-radius:10px;background:linear-gradient(135deg,#3b82f6,#1d4ed8);display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.78rem;flex-shrink:0;">
                                        {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                                    </div>
                                    <div style="min-width:0;">
                                        <div
                                            style="font-weight:700;color:#1e293b;font-size:0.87rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:130px;">
                                            {{ $booking->user->name }}</div>
                                        <div
                                            style="color:#94a3b8;font-size:0.72rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:130px;">
                                            {{ $booking->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            {{-- Ruangan --}}
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div
                                        style="width:28px;height:28px;border-radius:8px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="bi bi-building" style="font-size:0.75rem;color:#3b82f6;"></i>
                                    </div>
                                    <span
                                        style="font-weight:600;color:#334155;font-size:0.87rem;">{{ $booking->room->nama_ruangan }}</span>
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
                            <td class="d-none d-xl-table-cell" style="max-width:200px;">
                                <span
                                    style="color:#64748b;font-size:0.82rem;">{{ Str::limit($booking->keperluan, 55) }}</span>
                            </td>
                            {{-- Status --}}
                            <td>
                                @if ($booking->status == 'pending')
                                    <span class="badge-pending">⏳ Pending</span>
                                @elseif($booking->status == 'approved')
                                    <span class="badge-approved">✓ Approved</span>
                                @elseif($booking->status == 'rejected')
                                    <span class="badge-rejected">✕ Rejected</span>
                                @endif
                            </td>
                            {{-- Aksi --}}
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    @if ($booking->status == 'pending')
                                        <form action="/admin/booking/{{ $booking->id }}/approve" method="POST"
                                            class="m-0">
                                            @csrf
                                            <button type="submit" class="d-inline-flex align-items-center gap-1 px-3 py-1"
                                                style="background:#dcfce7;color:#15803d;border:1px solid #bbf7d0;border-radius:8px;font-size:0.75rem;font-weight:700;cursor:pointer;">
                                                <i class="bi bi-check-lg"></i> Approve
                                            </button>
                                        </form>
                                        <form action="/admin/booking/{{ $booking->id }}/reject" method="POST"
                                            class="m-0" onsubmit="return confirm('Yakin ingin menolak booking ini?')">
                                            @csrf
                                            <button type="submit" class="d-inline-flex align-items-center gap-1 px-3 py-1"
                                                style="background:#fee2e2;color:#991b1b;border:1px solid #fecaca;border-radius:8px;font-size:0.75rem;font-weight:700;cursor:pointer;">
                                                <i class="bi bi-x-lg"></i> Reject
                                            </button>
                                        </form>
                                    @else
                                        <span style="color:#cbd5e1;font-size:0.78rem;font-weight:600;">—</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-calendar2-x d-block mb-2" style="font-size:2.2rem;color:#cbd5e1;"></i>
                                <span style="color:#94a3b8;font-size:0.85rem;">Tidak ada data booking</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if (method_exists($bookings, 'hasPages') && $bookings->hasPages())
            <div class="card-footer bg-white border-top-0 py-3">{{ $bookings->links() }}</div>
        @endif
    </div>

@endsection
