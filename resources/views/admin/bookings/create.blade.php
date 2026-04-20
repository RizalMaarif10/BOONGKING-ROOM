@extends('layouts.admin')

@section('page_title', 'Booking Ruangan')
@section('page_subtitle', 'Ajukan permintaan penggunaan ruangan')

@section('content')

    <div style="max-width:660px;">
        <a href="{{ url()->previous() }}" class="d-inline-flex align-items-center gap-2 mb-4 text-decoration-none"
            style="font-size:0.85rem;font-weight:600;color:#64748b;">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

        @if ($errors->any())
            <div class="d-flex align-items-start gap-2 p-3 mb-4 rounded-3"
                style="background:#fee2e2;border:1px solid #fecaca;color:#991b1b;font-size:0.84rem;">
                <i class="bi bi-exclamation-circle-fill mt-1 flex-shrink-0"></i>
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <div style="width:4px;height:18px;background:linear-gradient(180deg,#3b82f6,#6366f1);border-radius:999px;">
                </div>
                Form Pengajuan Booking
            </div>
            <div class="card-body p-4">
                <form action="/bookings" method="POST">
                    @csrf

                    {{-- Pilih Ruangan --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.87rem;color:#334155;">
                            Pilih Ruangan <span class="text-danger">*</span>
                        </label>
                        <select name="room_id" class="form-select {{ $errors->has('room_id') ? 'is-invalid' : '' }}"
                            style="border-radius:10px;font-size:0.9rem;padding:10px 14px;border-color:#e2e8f0;"
                            onchange="updateRoomInfo(this)">
                            <option value="">— Pilih ruangan —</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" data-jenis="{{ $room->jenis_ruangan }}"
                                    data-kapasitas="{{ $room->kapasitas }}" data-fasilitas="{{ $room->fasilitas }}"
                                    {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                    {{ $room->nama_ruangan }}
                                </option>
                            @endforeach
                        </select>
                        {{-- Info ruangan --}}
                        <div id="room-info"
                            style="display:none;margin-top:10px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:12px 14px;">
                            <div class="d-flex flex-wrap gap-3">
                                <div>
                                    <div
                                        style="font-size:0.68rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;">
                                        Jenis</div>
                                    <div id="info-jenis"
                                        style="font-size:0.85rem;font-weight:700;color:#334155;margin-top:2px;"></div>
                                </div>
                                <div>
                                    <div
                                        style="font-size:0.68rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;">
                                        Kapasitas</div>
                                    <div id="info-kapasitas"
                                        style="font-size:0.85rem;font-weight:700;color:#334155;margin-top:2px;"></div>
                                </div>
                                <div>
                                    <div
                                        style="font-size:0.68rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;">
                                        Fasilitas</div>
                                    <div id="info-fasilitas"
                                        style="font-size:0.85rem;font-weight:600;color:#64748b;margin-top:2px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tanggal --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.87rem;color:#334155;">
                            Tanggal Booking <span class="text-danger">*</span>
                        </label>
                        <div class="input-group" style="border-radius:10px;overflow:hidden;">
                            <span class="input-group-text" style="background:#f8fafc;border-color:#e2e8f0;color:#64748b;">
                                <i class="bi bi-calendar3"></i>
                            </span>
                            <input type="date" name="tanggal" value="{{ old('tanggal') }}" min="{{ date('Y-m-d') }}"
                                class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : '' }}"
                                style="font-size:0.9rem;padding:10px 14px;border-color:#e2e8f0;">
                        </div>
                    </div>

                    {{-- Jam --}}
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label class="form-label fw-semibold" style="font-size:0.87rem;color:#334155;">
                                Jam Mulai <span class="text-danger">*</span>
                            </label>
                            <div class="input-group" style="border-radius:10px;overflow:hidden;">
                                <span class="input-group-text"
                                    style="background:#f8fafc;border-color:#e2e8f0;color:#64748b;">
                                    <i class="bi bi-clock"></i>
                                </span>
                                <input type="time" name="jam_mulai" value="{{ old('jam_mulai') }}"
                                    class="form-control {{ $errors->has('jam_mulai') ? 'is-invalid' : '' }}"
                                    style="font-size:0.9rem;padding:10px 14px;border-color:#e2e8f0;">
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold" style="font-size:0.87rem;color:#334155;">
                                Jam Selesai <span class="text-danger">*</span>
                            </label>
                            <div class="input-group" style="border-radius:10px;overflow:hidden;">
                                <span class="input-group-text"
                                    style="background:#f8fafc;border-color:#e2e8f0;color:#64748b;">
                                    <i class="bi bi-clock-fill"></i>
                                </span>
                                <input type="time" name="jam_selesai" value="{{ old('jam_selesai') }}"
                                    class="form-control {{ $errors->has('jam_selesai') ? 'is-invalid' : '' }}"
                                    style="font-size:0.9rem;padding:10px 14px;border-color:#e2e8f0;">
                            </div>
                        </div>
                    </div>

                    {{-- Keperluan --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.87rem;color:#334155;">
                            Keperluan <span class="text-danger">*</span>
                        </label>
                        <textarea name="keperluan" rows="3" placeholder="Jelaskan tujuan penggunaan ruangan..."
                            class="form-control {{ $errors->has('keperluan') ? 'is-invalid' : '' }}"
                            style="border-radius:10px;font-size:0.9rem;padding:10px 14px;border-color:#e2e8f0;resize:none;">{{ old('keperluan') }}</textarea>
                    </div>

                    {{-- Disclaimer --}}
                    <div class="d-flex align-items-start gap-2 p-3 mb-4 rounded-3"
                        style="background:#fefce8;border:1px solid #fef08a;">
                        <i class="bi bi-info-circle-fill flex-shrink-0 mt-1" style="color:#ca8a04;font-size:0.85rem;"></i>
                        <p class="mb-0" style="font-size:0.78rem;color:#854d0e;line-height:1.6;">
                            Booking akan diproses setelah mendapat persetujuan admin. Anda akan mendapat notifikasi melalui
                            akun Anda.
                        </p>
                    </div>

                    <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                        <a href="{{ url()->previous() }}" class="btn"
                            style="border-radius:10px;font-size:0.85rem;font-weight:600;background:#f1f5f9;color:#475569;border:none;padding:9px 18px;">
                            Batal
                        </a>
                        <button type="submit" class="btn d-inline-flex align-items-center gap-2"
                            style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);color:white;border:none;border-radius:10px;font-size:0.85rem;font-weight:700;padding:9px 22px;">
                            <i class="bi bi-send-fill"></i> Ajukan Booking
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        function updateRoomInfo(sel) {
            const opt = sel.options[sel.selectedIndex];
            const info = document.getElementById('room-info');
            if (!sel.value) {
                info.style.display = 'none';
                return;
            }
            document.getElementById('info-jenis').textContent = opt.dataset.jenis || '—';
            document.getElementById('info-kapasitas').textContent = (opt.dataset.kapasitas || '—') + ' orang';
            document.getElementById('info-fasilitas').textContent = opt.dataset.fasilitas || '—';
            info.style.display = 'block';
        }
        // trigger on load if old value exists
        document.addEventListener('DOMContentLoaded', () => {
            const sel = document.querySelector('[name=room_id]');
            if (sel && sel.value) updateRoomInfo(sel);
        });
    </script>

@endsection
