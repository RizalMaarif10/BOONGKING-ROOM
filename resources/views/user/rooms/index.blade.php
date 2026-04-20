@extends('layouts.user')

@section('title', 'Daftar Ruangan')

@section('content')

    {{-- ── HERO ── --}}
    <div
        style="background:linear-gradient(135deg,#0f172a 0%,#1e3a5f 60%,#1d4ed8 100%);border-radius:20px;padding:44px 40px;margin-bottom:32px;position:relative;overflow:hidden;">
        <div
            style="position:absolute;inset:0;background-image:radial-gradient(rgba(255,255,255,0.07) 1.5px,transparent 1.5px);background-size:26px 26px;">
        </div>
        <div
            style="position:absolute;width:300px;height:300px;border-radius:50%;background:rgba(59,130,246,0.15);top:-100px;right:-60px;filter:blur(60px);">
        </div>
        <div
            style="position:absolute;width:200px;height:200px;border-radius:50%;background:rgba(255,255,255,0.05);bottom:-60px;left:20%;filter:blur(40px);">
        </div>
        <div style="position:relative;z-index:1;">
            <div class="d-flex align-items-center gap-2 mb-3">
                <span
                    style="background:rgba(59,130,246,0.3);border:1px solid rgba(59,130,246,0.5);color:#93c5fd;font-size:0.75rem;font-weight:700;padding:4px 12px;border-radius:999px;letter-spacing:0.05em;">
                    <i class="bi bi-building me-1"></i>SISTEM BOOKING
                </span>
            </div>
            <h1 style="color:white;font-weight:800;font-size:clamp(1.5rem,3vw,2.2rem);margin-bottom:10px;line-height:1.2;">
                Reservasi Ruangan Kampus
            </h1>
            <p style="color:rgba(255,255,255,0.6);font-size:0.92rem;margin-bottom:24px;max-width:480px;line-height:1.7;">
                Pilih ruangan yang tersedia dan ajukan booking sesuai kebutuhan. Proses persetujuan akan dilakukan oleh
                admin.
            </p>
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <div class="d-flex align-items-center gap-2"
                    style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);border-radius:10px;padding:8px 14px;">
                    <i class="bi bi-building" style="color:#93c5fd;"></i>
                    <span style="color:white;font-size:0.82rem;font-weight:700;">{{ count($rooms) }} Ruangan Tersedia</span>
                </div>
                <a href="/booking/riwayat"
                    style="display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);color:white;font-size:0.82rem;font-weight:700;padding:8px 14px;border-radius:10px;text-decoration:none;">
                    <i class="bi bi-clock-history"></i> Riwayat Booking Saya
                </a>
            </div>
        </div>
    </div>

    {{-- ── FILTER / SEARCH ── --}}
    <div class="d-flex align-items-center justify-content-between mb-4 gap-3 flex-wrap">
        <div class="d-flex align-items-center gap-2 flex-wrap">
            @php $jenis = request('jenis', 'all'); @endphp
            @foreach (['all' => 'Semua'] as $val => $label)
                <a href="?jenis={{ $val }}"
                    class="d-inline-flex align-items-center gap-1 px-3 py-2 rounded-3 text-decoration-none"
                    style="font-size:0.8rem;font-weight:700;transition:all 0.15s;
                background:{{ $jenis == $val ? '#1e293b' : '#f1f5f9' }};
                color:{{ $jenis == $val ? 'white' : '#64748b' }};
                border:1px solid {{ $jenis == $val ? '#1e293b' : '#e2e8f0' }};">
                    {{ $label }}
                </a>
            @endforeach
        </div>
        <span style="font-size:0.8rem;color:#94a3b8;font-weight:600;">
            Menampilkan {{ count($rooms) }} ruangan
        </span>
    </div>

    {{-- ── ROOM CARDS ── --}}
    <div class="row g-4">
        @forelse($rooms as $room)
            <div class="col-md-6 col-xl-4">
                <div class="card h-100" style="transition:transform 0.2s,box-shadow 0.2s;"
                    onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 32px rgba(0,0,0,0.1)'"
                    onmouseout="this.style.transform='';this.style.boxShadow=''">

                    {{-- Colored top band --}}
                    @php
                        $bandColor = match ($room->jenis_ruangan) {
                            'Laboratorium' => 'linear-gradient(135deg,#3b82f6,#1d4ed8)',
                            'Ruang Kelas' => 'linear-gradient(135deg,#22c55e,#15803d)',
                            'Ruang Sidang' => 'linear-gradient(135deg,#8b5cf6,#6d28d9)',
                            default => 'linear-gradient(135deg,#64748b,#475569)',
                        };
                        $jenisColor = match ($room->jenis_ruangan) {
                            'Laboratorium' => ['bg' => '#eff6ff', 'color' => '#1d4ed8', 'border' => '#bfdbfe'],
                            'Ruang Kelas' => ['bg' => '#f0fdf4', 'color' => '#15803d', 'border' => '#bbf7d0'],
                            'Ruang Sidang' => ['bg' => '#faf5ff', 'color' => '#6d28d9', 'border' => '#e9d5ff'],
                            default => ['bg' => '#f1f5f9', 'color' => '#475569', 'border' => '#e2e8f0'],
                        };
                    @endphp

                    <div style="height:6px;background:{{ $bandColor }};border-radius:16px 16px 0 0;"></div>

                    <div class="card-body p-4 d-flex flex-column">

                        {{-- Header --}}
                        <div class="d-flex align-items-start justify-content-between mb-3">
                            <div class="d-flex align-items-center gap-3">
                                <div
                                    style="width:44px;height:44px;border-radius:12px;background:{{ $bandColor }};display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="bi bi-{{ $room->jenis_ruangan == 'Laboratorium' ? 'pc-display' : ($room->jenis_ruangan == 'Ruang Sidang' ? 'people-fill' : 'journal-text') }} text-white"
                                        style="font-size:1.1rem;"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold" style="color:#1e293b;font-size:0.97rem;">
                                        {{ $room->nama_ruangan }}</h6>
                                    <span
                                        style="background:{{ $jenisColor['bg'] }};color:{{ $jenisColor['color'] }};border:1px solid {{ $jenisColor['border'] }};font-size:0.68rem;font-weight:700;padding:2px 8px;border-radius:999px;margin-top:4px;display:inline-block;">
                                        {{ $room->jenis_ruangan }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Kapasitas --}}
                        <div class="d-flex align-items-center gap-2 mb-3 p-3 rounded-3"
                            style="background:#f8fafc;border:1px solid #e2e8f0;">
                            <i class="bi bi-people-fill" style="color:#94a3b8;"></i>
                            <span style="font-size:0.84rem;color:#64748b;">Kapasitas</span>
                            <span class="ms-auto fw-bold" style="font-size:0.95rem;color:#1e293b;">{{ $room->kapasitas }}
                                <span style="font-size:0.75rem;font-weight:600;color:#94a3b8;">orang</span></span>
                        </div>

                        {{-- Fasilitas --}}
                        <div class="mb-4">
                            <p
                                style="font-size:0.68rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:8px;">
                                Fasilitas</p>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach (array_slice(array_map('trim', explode(',', $room->fasilitas)), 0, 4) as $f)
                                    <span
                                        style="background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;font-size:0.72rem;font-weight:600;padding:3px 8px;border-radius:6px;">
                                        {{ $f }}
                                    </span>
                                @endforeach
                                @if (count(explode(',', $room->fasilitas)) > 4)
                                    <span
                                        style="background:#f1f5f9;color:#94a3b8;border:1px solid #e2e8f0;font-size:0.72rem;font-weight:600;padding:3px 8px;border-radius:6px;">
                                        +{{ count(explode(',', $room->fasilitas)) - 4 }} lagi
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- CTA --}}
                        <a href="/booking/create?room={{ $room->id }}"
                            class="btn w-100 d-flex align-items-center justify-content-center gap-2 mt-auto"
                            style="background:{{ $bandColor }};color:white;border:none;border-radius:10px;font-size:0.85rem;font-weight:700;padding:11px;text-decoration:none;">
                            <i class="bi bi-calendar2-plus"></i> Booking Ruangan Ini
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <div
                            style="width:60px;height:60px;border-radius:16px;background:#f1f5f9;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;">
                            <i class="bi bi-building-x" style="font-size:1.6rem;color:#cbd5e1;"></i>
                        </div>
                        <p style="color:#94a3b8;font-size:0.85rem;margin:0;">Tidak ada ruangan tersedia saat ini.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

@endsection
