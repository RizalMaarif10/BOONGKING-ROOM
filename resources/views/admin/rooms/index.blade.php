@extends('layouts.admin')

@section('page_title', 'Manajemen Ruangan')
@section('page_subtitle', 'Kelola data ruangan yang tersedia untuk booking')

@section('content')

    {{-- Header Aksi --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <span style="font-size:0.8rem;color:#94a3b8;font-weight:600;">
            {{ $rooms->count() }} ruangan terdaftar
        </span>
        <div class="d-flex align-items-center gap-2">
            {{-- Tombol Kelola Jenis Ruangan --}}
            <a href="{{ route('admin.jenis-ruangan.index') }}" class="d-inline-flex align-items-center gap-2"
                style="background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;border-radius:10px;font-weight:600;font-size:0.82rem;padding:8px 16px;text-decoration:none;">
                <i class="bi bi-tags"></i> Jenis Ruangan
            </a>
            {{-- Tombol Tambah Ruangan --}}
            <a href="{{ route('admin.rooms.create') }}" class="d-inline-flex align-items-center gap-2"
                style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);color:white;border:none;border-radius:10px;font-weight:600;font-size:0.82rem;padding:8px 16px;text-decoration:none;">
                <i class="bi bi-plus-lg"></i> Tambah Ruangan
            </a>
        </div>
    </div>

    {{-- Alert Success --}}
    @if (session('success'))
        <div class="d-flex align-items-center gap-2 p-3 mb-4 rounded-3"
            style="background:#dcfce7;border:1px solid #bbf7d0;color:#15803d;font-size:0.85rem;font-weight:600;">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Alert Error --}}
    @if (session('error'))
        <div class="d-flex align-items-center gap-2 p-3 mb-4 rounded-3"
            style="background:#fee2e2;border:1px solid #fecaca;color:#991b1b;font-size:0.85rem;font-weight:600;">
            <i class="bi bi-x-circle-fill"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Ruangan</th>
                        <th>Jenis</th>
                        <th class="d-none d-md-table-cell">Kapasitas</th>
                        <th class="d-none d-xl-table-cell">Fasilitas</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rooms as $room)
                        <tr>
                            {{-- Nama Ruangan --}}
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div
                                        style="width:34px;height:34px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                        <i class="bi bi-building" style="font-size:0.85rem;color:#3b82f6;"></i>
                                    </div>
                                    <div>
                                        <div style="font-weight:700;color:#1e293b;font-size:0.87rem;">
                                            {{ $room->nama_ruangan }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Jenis --}}
                            <td>
                                @if ($room->jenisRuangan)
                                    <span
                                        style="display:inline-flex;align-items:center;gap:5px;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;border-radius:8px;font-size:0.75rem;font-weight:700;padding:3px 10px;">
                                        <i class="bi bi-tag" style="font-size:0.7rem;"></i>
                                        {{ $room->jenisRuangan->nama }}
                                    </span>
                                @else
                                    <span style="color:#cbd5e1;font-size:0.78rem;font-weight:600;">—</span>
                                @endif
                            </td>

                            {{-- Kapasitas --}}
                            <td class="d-none d-md-table-cell">
                                <div class="d-flex align-items-center gap-1">
                                    <i class="bi bi-people" style="color:#94a3b8;font-size:0.8rem;"></i>
                                    <span style="font-size:0.82rem;font-weight:600;color:#334155;">
                                        {{ $room->kapasitas }} orang
                                    </span>
                                </div>
                            </td>

                            {{-- Fasilitas --}}
                            <td class="d-none d-xl-table-cell" style="max-width:220px;">
                                <span style="color:#64748b;font-size:0.82rem;">
                                    {{ Str::limit($room->fasilitas, 60) }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.rooms.edit', $room->id) }}"
                                        class="d-inline-flex align-items-center gap-1 px-3 py-1"
                                        style="background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;border-radius:8px;font-size:0.75rem;font-weight:700;text-decoration:none;">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST"
                                        class="m-0" onsubmit="return confirm('Yakin ingin menghapus ruangan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="d-inline-flex align-items-center gap-1 px-3 py-1"
                                            style="background:#fee2e2;color:#991b1b;border:1px solid #fecaca;border-radius:8px;font-size:0.75rem;font-weight:700;cursor:pointer;">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-building d-block mb-2" style="font-size:2.2rem;color:#cbd5e1;"></i>
                                <span style="color:#94a3b8;font-size:0.85rem;">Belum ada data ruangan</span>
                                <div class="mt-2">
                                    <a href="{{ route('admin.rooms.create') }}"
                                        style="font-size:0.82rem;font-weight:700;color:#3b82f6;text-decoration:none;">
                                        + Tambah Ruangan Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
