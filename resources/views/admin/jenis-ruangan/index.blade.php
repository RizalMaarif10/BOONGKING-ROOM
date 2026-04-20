@extends('layouts.admin')

@section('page_title', 'Jenis Ruangan')
@section('page_subtitle', 'Kelola kategori jenis ruangan yang tersedia')

@section('content')

    <div class="row g-4">

        {{-- Form Tambah --}}
        <div class="col-12 col-lg-4">
            <div class="card h-auto">
                <div class="card-body p-4">
                    <h6 style="font-weight:700;color:#1e293b;margin-bottom:16px;">
                        <i class="bi bi-plus-circle me-2" style="color:#3b82f6;"></i>Tambah Jenis Ruangan
                    </h6>
                    <form action="{{ route('admin.jenis-ruangan.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label style="font-size:0.8rem;font-weight:700;color:#475569;">Nama Jenis</label>
                            <input type="text" name="nama" value="{{ old('nama') }}"
                                placeholder="contoh: Laboratorium, Aula, Ruang Kelas..."
                                class="form-control mt-1 @error('nama') is-invalid @enderror"
                                style="font-size:0.85rem;border-radius:10px;">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="w-100 d-flex align-items-center justify-content-center gap-2"
                            style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);color:white;border:none;border-radius:10px;font-weight:700;font-size:0.85rem;padding:10px;">
                            <i class="bi bi-plus-lg"></i> Tambah
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Tabel List --}}
        <div class="col-12 col-lg-8">

            {{-- Alert --}}
            @if (session('success'))
                <div class="d-flex align-items-center gap-2 p-3 mb-3 rounded-3"
                    style="background:#dcfce7;border:1px solid #bbf7d0;color:#15803d;font-size:0.85rem;font-weight:600;">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="d-flex align-items-center gap-2 p-3 mb-3 rounded-3"
                    style="background:#fee2e2;border:1px solid #fecaca;color:#991b1b;font-size:0.85rem;font-weight:600;">
                    <i class="bi bi-x-circle-fill"></i> {{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Jenis</th>
                                <th class="d-none d-md-table-cell">Jumlah Ruangan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jenis as $item)
                                <tr>
                                    <td style="color:#94a3b8;font-size:0.82rem;">{{ $loop->iteration }}</td>

                                    {{-- Nama / Inline Edit --}}
                                    <td>
                                        <div id="label-{{ $item->id }}">
                                            <span style="font-weight:700;color:#1e293b;font-size:0.87rem;">
                                                {{ $item->nama }}
                                            </span>
                                        </div>
                                        <form id="form-{{ $item->id }}"
                                            action="{{ route('admin.jenis-ruangan.update', $item->id) }}" method="POST"
                                            class="d-none">
                                            @csrf
                                            @method('PUT')
                                            <div class="d-flex gap-2 align-items-center">
                                                <input type="text" name="nama" value="{{ $item->nama }}"
                                                    class="form-control form-control-sm"
                                                    style="font-size:0.82rem;border-radius:8px;">
                                                <button type="submit"
                                                    style="background:#dcfce7;color:#15803d;border:1px solid #bbf7d0;border-radius:8px;font-size:0.75rem;font-weight:700;padding:4px 10px;white-space:nowrap;">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                                <button type="button" onclick="cancelEdit({{ $item->id }})"
                                                    style="background:#f1f5f9;color:#64748b;border:1px solid #e2e8f0;border-radius:8px;font-size:0.75rem;font-weight:700;padding:4px 10px;">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>

                                    {{-- Jumlah Ruangan --}}
                                    <td class="d-none d-md-table-cell">
                                        <span style="font-size:0.82rem;font-weight:600;color:#64748b;">
                                            {{ $item->rooms_count }} ruangan
                                        </span>
                                    </td>

                                    {{-- Aksi --}}
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <button onclick="startEdit({{ $item->id }})"
                                                id="btn-edit-{{ $item->id }}"
                                                style="background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;border-radius:8px;font-size:0.75rem;font-weight:700;padding:4px 12px;">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <form action="{{ route('admin.jenis-ruangan.destroy', $item->id) }}"
                                                method="POST" class="m-0"
                                                onsubmit="return confirm('Yakin hapus jenis ruangan ini? Ruangan terkait tidak akan terhapus.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    style="background:#fee2e2;color:#991b1b;border:1px solid #fecaca;border-radius:8px;font-size:0.75rem;font-weight:700;padding:4px 12px;cursor:pointer;">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <i class="bi bi-tags d-block mb-2" style="font-size:2.2rem;color:#cbd5e1;"></i>
                                        <span style="color:#94a3b8;font-size:0.85rem;">Belum ada jenis ruangan</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function startEdit(id) {
            document.getElementById('label-' + id).classList.add('d-none');
            document.getElementById('form-' + id).classList.remove('d-none');
            document.getElementById('btn-edit-' + id).classList.add('d-none');
        }

        function cancelEdit(id) {
            document.getElementById('label-' + id).classList.remove('d-none');
            document.getElementById('form-' + id).classList.add('d-none');
            document.getElementById('btn-edit-' + id).classList.remove('d-none');
        }
    </script>

@endsection
