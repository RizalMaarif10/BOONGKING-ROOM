@extends('layouts.user')

@section('title', 'Booking Ruangan')

@section('content')

<style>
    #conflict-alert         { display: none !important; }
    #conflict-alert.show    { display: flex !important; }
</style>

{{-- ── TOAST SUCCESS ── --}}
@if (session('success'))
    <div id="toast-success"
        style="position:fixed;top:80px;right:24px;z-index:9999;min-width:320px;max-width:420px;
               background:white;border-radius:16px;box-shadow:0 8px 32px rgba(0,0,0,0.15);
               border:1px solid #bbf7d0;padding:18px 20px;
               display:flex;align-items:flex-start;gap:14px;
               animation:slideIn 0.4s ease;">
        <div style="width:42px;height:42px;border-radius:12px;
                    background:linear-gradient(135deg,#22c55e,#15803d);
                    display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="bi bi-check-lg text-white" style="font-size:1.2rem;"></i>
        </div>
        <div style="flex:1;min-width:0;">
            <div style="font-weight:700;color:#15803d;font-size:0.9rem;margin-bottom:4px;">
                🎉 Booking Berhasil Diajukan!
            </div>
            <div style="color:#64748b;font-size:0.81rem;line-height:1.6;">
                {{ session('success') }}
            </div>
            <div style="margin-top:10px;display:flex;gap:8px;">
                <a href="{{ route('booking.index') }}"
                    style="font-size:0.78rem;font-weight:700;color:white;background:#22c55e;
                           padding:5px 12px;border-radius:8px;text-decoration:none;">
                    Lihat Riwayat
                </a>
                <button onclick="closeToast()"
                    style="font-size:0.78rem;font-weight:600;color:#64748b;background:#f1f5f9;
                           border:none;padding:5px 12px;border-radius:8px;cursor:pointer;">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    <style>
        @keyframes slideIn {
            from { opacity:0; transform:translateX(80px); }
            to   { opacity:1; transform:translateX(0); }
        }
        @keyframes slideOut {
            from { opacity:1; transform:translateX(0); }
            to   { opacity:0; transform:translateX(80px); }
        }
    </style>
    <script>
        setTimeout(() => closeToast(), 6000);
        function closeToast() {
            const t = document.getElementById('toast-success');
            if (t) {
                t.style.animation = 'slideOut 0.3s ease forwards';
                setTimeout(() => t.remove(), 300);
            }
        }
    </script>
@endif

{{-- ── HEADER ── --}}
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="fw-bold text-dark mb-0">Booking Ruangan</h5>
        <small class="text-muted">Ajukan peminjaman ruangan sesuai kebutuhan</small>
    </div>
    <a href="{{ route('booking.index') }}" class="btn d-inline-flex align-items-center gap-2"
        style="background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;border-radius:10px;
               font-weight:600;font-size:0.82rem;padding:8px 16px;text-decoration:none;">
        <i class="bi bi-clock-history"></i> Riwayat Saya
    </a>
</div>

{{-- ── ERROR SESSION ── --}}
@if (session('error'))
    <div class="d-flex align-items-center gap-2 p-3 mb-4 rounded-3"
        style="background:#fee2e2;border:1px solid #fecaca;color:#991b1b;font-size:0.85rem;font-weight:600;">
        <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
    </div>
@endif

{{-- ── VALIDATION ERRORS ── --}}
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

<div class="row g-4">

    {{-- ── FORM ── --}}
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <div style="width:4px;height:18px;background:linear-gradient(180deg,#3b82f6,#6366f1);border-radius:999px;"></div>
                Form Pengajuan Booking
            </div>
            <div class="card-body p-4">
                <form action="{{ route('booking.store') }}" method="POST" id="booking-form">
                    @csrf

                    {{-- Pilih Ruangan --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.87rem;color:#334155;">
                            Pilih Ruangan <span class="text-danger">*</span>
                        </label>
                        <select name="room_id" id="room"
                            class="form-select {{ $errors->has('room_id') ? 'is-invalid' : '' }}"
                            style="border-radius:10px;font-size:0.9rem;padding:10px 14px;border-color:#e2e8f0;"
                            onchange="updateRoomInfo(this); loadSlots();">
                            <option value="">— Pilih ruangan —</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}"
                                    data-jenis="{{ $room->jenisRuangan ? $room->jenisRuangan->nama : '—' }}"
                                    data-kapasitas="{{ $room->kapasitas }}"
                                    data-fasilitas="{{ $room->fasilitas }}"
                                    {{ old('room_id', request('room')) == $room->id ? 'selected' : '' }}>
                                    {{ $room->nama_ruangan }}
                                </option>
                            @endforeach
                        </select>

                        <div id="room-info"
                            style="display:none;margin-top:10px;background:#f8fafc;
                                   border:1px solid #e2e8f0;border-radius:10px;padding:12px 14px;">
                            <div class="d-flex flex-wrap gap-4">
                                <div>
                                    <div style="font-size:0.68rem;font-weight:700;color:#94a3b8;
                                                text-transform:uppercase;letter-spacing:0.08em;">Jenis</div>
                                    <div id="info-jenis"
                                        style="font-size:0.85rem;font-weight:700;color:#334155;margin-top:2px;"></div>
                                </div>
                                <div>
                                    <div style="font-size:0.68rem;font-weight:700;color:#94a3b8;
                                                text-transform:uppercase;letter-spacing:0.08em;">Kapasitas</div>
                                    <div id="info-kapasitas"
                                        style="font-size:0.85rem;font-weight:700;color:#334155;margin-top:2px;"></div>
                                </div>
                                <div>
                                    <div style="font-size:0.68rem;font-weight:700;color:#94a3b8;
                                                text-transform:uppercase;letter-spacing:0.08em;">Fasilitas</div>
                                    <div id="info-fasilitas"
                                        style="font-size:0.85rem;font-weight:600;color:#64748b;margin-top:2px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tanggal + Keperluan --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:0.87rem;color:#334155;">
                                Tanggal <span class="text-danger">*</span>
                            </label>
                            <div class="input-group" style="border-radius:10px;overflow:hidden;">
                                <span class="input-group-text"
                                    style="background:#f8fafc;border-color:#e2e8f0;color:#64748b;">
                                    <i class="bi bi-calendar3"></i>
                                </span>
                                <input type="date" name="tanggal" id="tanggal"
                                    value="{{ old('tanggal') }}"
                                    min="{{ date('Y-m-d') }}"
                                    class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : '' }}"
                                    style="font-size:0.9rem;padding:10px 14px;border-color:#e2e8f0;"
                                    onchange="loadSlots()">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" style="font-size:0.87rem;color:#334155;">
                                Keperluan <span class="text-danger">*</span>
                            </label>
                            <div class="input-group" style="border-radius:10px;overflow:hidden;">
                                <span class="input-group-text"
                                    style="background:#f8fafc;border-color:#e2e8f0;color:#64748b;">
                                    <i class="bi bi-card-text"></i>
                                </span>
                                <input type="text" name="keperluan" value="{{ old('keperluan') }}"
                                    placeholder="Contoh: Praktikum, Rapat"
                                    class="form-control {{ $errors->has('keperluan') ? 'is-invalid' : '' }}"
                                    style="font-size:0.9rem;padding:10px 14px;border-color:#e2e8f0;">
                            </div>
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
                                <input type="time" name="jam_mulai" id="jam_mulai"
                                    value="{{ old('jam_mulai') }}"
                                    class="form-control {{ $errors->has('jam_mulai') ? 'is-invalid' : '' }}"
                                    style="font-size:0.9rem;padding:10px 14px;border-color:#e2e8f0;"
                                    onchange="checkConflict()">
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
                                <input type="time" name="jam_selesai" id="jam_selesai"
                                    value="{{ old('jam_selesai') }}"
                                    class="form-control {{ $errors->has('jam_selesai') ? 'is-invalid' : '' }}"
                                    style="font-size:0.9rem;padding:10px 14px;border-color:#e2e8f0;"
                                    onchange="checkConflict()">
                            </div>
                        </div>
                    </div>

                    {{-- Conflict Alert --}}
                    <div id="conflict-alert"
                         class="d-flex align-items-center gap-2 p-3 mb-4 rounded-3"
                         style="background:#fee2e2;border:1px solid #fecaca;">
                        <i class="bi bi-exclamation-triangle-fill" style="color:#ef4444;flex-shrink:0;"></i>
                        <span style="font-size:0.84rem;font-weight:600;color:#991b1b;">
                            Jam bentrok dengan booking yang sudah ada. Silakan pilih jam lain.
                        </span>
                    </div>

                    {{-- Disclaimer --}}
                    <div class="d-flex align-items-start gap-2 p-3 mb-4 rounded-3"
                        style="background:#fefce8;border:1px solid #fef08a;">
                        <i class="bi bi-info-circle-fill flex-shrink-0 mt-1"
                            style="color:#ca8a04;font-size:0.85rem;"></i>
                        <p class="mb-0" style="font-size:0.78rem;color:#854d0e;line-height:1.6;">
                            Booking akan diproses setelah mendapat persetujuan admin.
                            Pastikan jam yang dipilih tidak bentrok.
                        </p>
                    </div>

                    <button id="submit-btn" type="submit"
                        class="btn w-100 d-flex align-items-center justify-content-center gap-2"
                        style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);color:white;border:none;
                               border-radius:12px;font-size:0.9rem;font-weight:700;padding:12px;">
                        <i class="bi bi-send-fill"></i> Ajukan Booking
                    </button>

                </form>
            </div>
        </div>
    </div>

    {{-- ── SLOT INFO ── --}}
    <div class="col-lg-5">
        <div class="card" style="position:sticky;top:80px;">
            <div class="card-header d-flex align-items-center gap-2">
                <div style="width:4px;height:18px;background:linear-gradient(180deg,#f59e0b,#d97706);border-radius:999px;"></div>
                Jadwal Ruangan
            </div>
            <div class="card-body p-4">
                <div id="slot-info">
                    <div class="text-center py-4">
                        <div style="width:52px;height:52px;border-radius:14px;background:#f1f5f9;
                                    display:flex;align-items:center;justify-content:center;margin:0 auto 12px;">
                            <i class="bi bi-calendar2-week" style="font-size:1.4rem;color:#cbd5e1;"></i>
                        </div>
                        <p style="color:#94a3b8;font-size:0.84rem;margin:0;">
                            Pilih ruangan dan tanggal untuk melihat jadwal yang sudah terpakai.
                        </p>
                    </div>
                </div>
                <div id="slot-loading" style="display:none;" class="text-center py-4">
                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                    <p style="color:#94a3b8;font-size:0.82rem;margin-top:10px;">Memuat jadwal...</p>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    var bookedSlots = [];
    var slotsLoaded = false;

    document.addEventListener('DOMContentLoaded', function () {
        // Reset jam saat halaman load
        document.getElementById('jam_mulai').value   = '';
        document.getElementById('jam_selesai').value = '';

        // Init room info jika ada old value
        var sel = document.getElementById('room');
        if (sel && sel.value) {
            updateRoomInfo(sel);
            loadSlots();
        }
    });

    function hideConflict() {
        document.getElementById('conflict-alert').classList.remove('show');
        var btn       = document.getElementById('submit-btn');
        btn.disabled      = false;
        btn.style.opacity = '1';
    }

    function showConflict() {
        document.getElementById('conflict-alert').classList.add('show');
        var btn       = document.getElementById('submit-btn');
        btn.disabled      = true;
        btn.style.opacity = '0.5';
    }

    function updateRoomInfo(sel) {
        var opt  = sel.options[sel.selectedIndex];
        var info = document.getElementById('room-info');

        if (!sel.value) {
            info.style.display = 'none';
            return;
        }

        document.getElementById('info-jenis').textContent     = opt.dataset.jenis      || '—';
        document.getElementById('info-kapasitas').textContent = (opt.dataset.kapasitas  || '—') + ' orang';
        document.getElementById('info-fasilitas').textContent = opt.dataset.fasilitas   || '—';
        info.style.display = 'block';

        // Reset saat ruangan diganti
        document.getElementById('jam_mulai').value   = '';
        document.getElementById('jam_selesai').value = '';
        bookedSlots = [];
        slotsLoaded = false;
        hideConflict();
    }

    function loadSlots() {
        var roomId  = document.getElementById('room').value;
        var tanggal = document.getElementById('tanggal').value;

        bookedSlots = [];
        slotsLoaded = false;
        hideConflict();

        document.getElementById('jam_mulai').value   = '';
        document.getElementById('jam_selesai').value = '';

        if (!roomId || !tanggal) return;

        document.getElementById('slot-loading').style.display = 'block';
        document.getElementById('slot-info').style.display    = 'none';

        fetch('/booking/slots?room_id=' + roomId + '&tanggal=' + tanggal)
            .then(function (r) { return r.json(); })
            .then(function (data) {
                bookedSlots = data;
                slotsLoaded = true;

                document.getElementById('slot-loading').style.display = 'none';
                document.getElementById('slot-info').style.display    = 'block';

                if (data.length === 0) {
                    document.getElementById('slot-info').innerHTML =
                        '<div class="d-flex align-items-center gap-2 p-3 rounded-3"' +
                        ' style="background:#f0fdf4;border:1px solid #bbf7d0;">' +
                        '<i class="bi bi-check-circle-fill" style="color:#22c55e;font-size:1rem;"></i>' +
                        '<span style="font-size:0.84rem;font-weight:600;color:#15803d;">Ruangan kosong di tanggal ini!</span>' +
                        '</div>';
                } else {
                    var rows = data.map(function (s) {
                        return '<div class="d-flex align-items-center justify-content-between px-3 py-2 rounded-3 mb-2"' +
                               ' style="background:#fef3c7;border:1px solid #fde68a;">' +
                               '<div class="d-flex align-items-center gap-2">' +
                               '<i class="bi bi-clock-fill" style="color:#d97706;font-size:0.8rem;"></i>' +
                               '<span style="font-weight:700;font-size:0.84rem;color:#92400e;">' + s.start + ' – ' + s.end + '</span>' +
                               '</div>' +
                               '<span style="font-size:0.7rem;font-weight:700;background:#fef9c3;color:#a16207;' +
                               'padding:2px 8px;border-radius:999px;border:1px solid #fde68a;">Terpakai</span>' +
                               '</div>';
                    }).join('');
                    document.getElementById('slot-info').innerHTML =
                        '<p style="font-size:0.77rem;font-weight:700;color:#94a3b8;' +
                        'text-transform:uppercase;letter-spacing:0.08em;margin-bottom:10px;">Jam Sudah Terpakai</p>' +
                        rows +
                        '<p style="font-size:0.74rem;color:#94a3b8;margin-top:10px;margin-bottom:0;">' +
                        '<i class="bi bi-info-circle me-1"></i>Pilih jam di luar slot di atas.</p>';
                }
            })
            .catch(function () {
                document.getElementById('slot-loading').style.display = 'none';
                document.getElementById('slot-info').style.display    = 'block';
                document.getElementById('slot-info').innerHTML =
                    '<span style="color:#ef4444;font-size:0.84rem;">Gagal memuat jadwal.</span>';
            });
    }

    function checkConflict() {
        var s = document.getElementById('jam_mulai').value;
        var e = document.getElementById('jam_selesai').value;

        if (!s || !e)          { hideConflict(); return; }
        if (!slotsLoaded)      { hideConflict(); return; }
        if (bookedSlots.length === 0) { hideConflict(); return; }

        var conflict = false;
        for (var i = 0; i < bookedSlots.length; i++) {
            var slot = bookedSlots[i];
            if ((s >= slot.start && s < slot.end) ||
                (e > slot.start  && e <= slot.end) ||
                (s <= slot.start && e >= slot.end)) {
                conflict = true;
                break;
            }
        }

        if (conflict) {
            showConflict();
            setTimeout(function () {
                document.getElementById('jam_mulai').value   = '';
                document.getElementById('jam_selesai').value = '';
                hideConflict();
            }, 2000);
        } else {
            hideConflict();
        }
    }

    document.getElementById('booking-form').addEventListener('submit', function (e) {
        var s   = document.getElementById('jam_mulai').value;
        var end = document.getElementById('jam_selesai').value;
        if (!s || !end) {
            e.preventDefault();
            return;
        }
        var btn       = document.getElementById('submit-btn');
        btn.disabled  = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Mengirim...';
    });
</script>

@endsection
