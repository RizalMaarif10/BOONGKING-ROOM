@extends('layouts.admin')

@section('page_title', 'Tambah Ruangan')
@section('page_subtitle', 'Tambah data ruangan baru')

@section('content')

    <div class="row justify-content-center">
        <div class="col-12 col-lg-7">

            <div class="card">
                <div class="card-body p-4">

                    @if (session('error'))
                        <div class="d-flex align-items-center gap-2 p-3 mb-4 rounded-3"
                            style="background:#fee2e2;border:1px solid #fecaca;color:#991b1b;font-size:0.85rem;font-weight:600;">
                            <i class="bi bi-x-circle-fill"></i> {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('admin.rooms.store') }}" method="POST">
                        @csrf

                        {{-- Nama Ruangan --}}
                        <div class="mb-3">
                            <label style="font-size:0.8rem;font-weight:700;color:#475569;">
                                Nama Ruangan <span style="color:#ef4444;">*</span>
                            </label>
                            <input type="text" name="nama_ruangan" value="{{ old('nama_ruangan') }}"
                                placeholder="contoh: Laboratorium Komputer A"
                                class="form-control mt-1 @error('nama_ruangan') is-invalid @enderror"
                                style="font-size:0.85rem;border-radius:10px;">
                            @error('nama_ruangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jenis Ruangan --}}
                        <div class="mb-3">
                            <label style="font-size:0.8rem;font-weight:700;color:#475569;">
                                Jenis Ruangan <span style="color:#ef4444;">*</span>
                            </label>
                            <select name="jenis_ruangan_id"
                                class="form-select mt-1 @error('jenis_ruangan_id') is-invalid @enderror"
                                style="font-size:0.85rem;border-radius:10px;">
                                <option value="">-- Pilih Jenis Ruangan --</option>
                                @foreach ($jenisRuangan as $jenis)
                                    <option value="{{ $jenis->id }}"
                                        {{ old('jenis_ruangan_id') == $jenis->id ? 'selected' : '' }}>
                                        {{ $jenis->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_ruangan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="mt-1">
                                <a href="{{ route('admin.jenis-ruangan.index') }}"
                                    style="font-size:0.75rem;color:#3b82f6;text-decoration:none;">
                                    + Tambah jenis ruangan baru
                                </a>
                            </div>
                        </div>

                        {{-- Kapasitas --}}
                        <div class="mb-3">
                            <label style="font-size:0.8rem;font-weight:700;color:#475569;">
                                Kapasitas <span style="color:#ef4444;">*</span>
                            </label>
                            <div class="input-group mt-1">
                                <input type="number" name="kapasitas" value="{{ old('kapasitas') }}" placeholder="0"
                                    min="1" class="form-control @error('kapasitas') is-invalid @enderror"
                                    style="font-size:0.85rem;border-radius:10px 0 0 10px;">
                                <span class="input-group-text"
                                    style="font-size:0.82rem;font-weight:600;color:#64748b;background:#f8fafc;border-radius:0 10px 10px 0;">
                                    orang
                                </span>
                                @error('kapasitas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Fasilitas --}}
                        <div class="mb-4">
                            <label style="font-size:0.8rem;font-weight:700;color:#475569;">
                                Fasilitas <span style="color:#ef4444;">*</span>
                            </label>
                            <textarea name="fasilitas" rows="3" placeholder="contoh: AC, Proyektor, Whiteboard, WiFi..."
                                class="form-control mt-1 @error('fasilitas') is-invalid @enderror" style="font-size:0.85rem;border-radius:10px;">{{ old('fasilitas') }}</textarea>
                            @error('fasilitas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.rooms.index') }}" class="flex-fill text-center py-2"
                                style="background:#f1f5f9;color:#64748b;border:1px solid #e2e8f0;border-radius:10px;font-size:0.85rem;font-weight:700;text-decoration:none;">
                                Batal
                            </a>
                            <button type="submit" class="flex-fill py-2"
                                style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);color:white;border:none;border-radius:10px;font-size:0.85rem;font-weight:700;">
                                <i class="bi bi-plus-lg me-1"></i> Simpan Ruangan
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>

@endsection
