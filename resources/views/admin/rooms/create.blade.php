@extends('layouts.admin')

@section('page_title', 'Tambah Ruangan')
@section('page_subtitle', 'Daftarkan ruangan baru ke dalam sistem')

@section('content')

    <style>
        .jenis-card {
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px 16px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .jenis-card:hover {
            border-color: #94a3b8;
            background: #f8fafc;
        }

        .jenis-card.selected-0 {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .jenis-card.selected-1 {
            border-color: #22c55e;
            background: #f0fdf4;
        }

        .jenis-card.selected-2 {
            border-color: #8b5cf6;
            background: #faf5ff;
        }

        .jenis-card.selected-3 {
            border-color: #f59e0b;
            background: #fffbeb;
        }

        .jenis-card.selected-4 {
            border-color: #ef4444;
            background: #fff1f2;
        }

        .jenis-card.selected-5 {
            border-color: #06b6d4;
            background: #ecfeff;
        }

        .fasilitas-tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            color: #475569;
            font-size: 0.78rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 999px;
            margin: 3px;
        }

        .fasilitas-tag .remove-tag {
            cursor: pointer;
            color: #94a3b8;
        }

        .fasilitas-tag .remove-tag:hover {
            color: #ef4444;
        }

        #tag-input {
            border: none;
            outline: none;
            font-size: 0.88rem;
            min-width: 140px;
            padding: 4px 2px;
            background: transparent;
        }

        #tag-wrap {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 8px 10px;
            min-height: 48px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 2px;
            cursor: text;
            transition: border-color 0.2s;
        }

        #tag-wrap:focus-within {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .step-badge {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            font-size: 0.72rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
    </style>

    <div>

        <a href="{{ route('admin.rooms.index') }}" class="d-inline-flex align-items-center gap-2 mb-4 text-decoration-none"
            style="font-size:0.85rem;font-weight:600;color:#64748b;">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
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

        {{-- Hero banner --}}
        <div class="mb-4 p-4 rounded-3 d-flex align-items-center gap-3"
            style="background:linear-gradient(135deg,#0f172a,#1e3a5f);position:relative;overflow:hidden;">
            <div
                style="position:absolute;inset:0;background-image:radial-gradient(rgba(255,255,255,0.05) 1px,transparent 1px);background-size:20px 20px;">
            </div>
            <div
                style="position:absolute;width:180px;height:180px;border-radius:50%;background:rgba(59,130,246,0.15);top:-60px;right:-40px;filter:blur(40px);">
            </div>
            <div
                style="width:52px;height:52px;border-radius:14px;background:linear-gradient(135deg,#3b82f6,#1d4ed8);display:flex;align-items:center;justify-content:center;flex-shrink:0;position:relative;z-index:1;box-shadow:0 8px 20px rgba(59,130,246,0.4);">
                <i class="bi bi-building-fill text-white" style="font-size:1.3rem;"></i>
            </div>
            <div style="position:relative;z-index:1;">
                <div style="color:white;font-weight:800;font-size:1.05rem;">Tambah Ruangan Baru</div>
                <div style="color:rgba(255,255,255,0.45);font-size:0.78rem;margin-top:2px;">Lengkapi semua informasi ruangan
                    di bawah ini</div>
            </div>
        </div>

        <div class="card" style="border-radius:20px!important;">
            <div class="card-body p-0">
                <form action="{{ route('admin.rooms.store') }}" method="POST" id="room-form">
                    @csrf

                    {{-- STEP 1: Nama --}}
                    <div class="p-4 border-bottom" style="border-color:#f1f5f9!important;">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="step-badge">1</div>
                            <span style="font-weight:700;font-size:0.9rem;color:#1e293b;">Nama Ruangan</span>
                        </div>
                        <input type="text" name="nama_ruangan" id="nama_ruangan" value="{{ old('nama_ruangan') }}"
                            placeholder="Contoh: Lab Komputer 1, Ruang Sidang A"
                            class="form-control {{ $errors->has('nama_ruangan') ? 'is-invalid' : '' }}"
                            style="border-radius:12px;font-size:0.95rem;padding:12px 16px;border:2px solid #e2e8f0;font-weight:600;"
                            oninput="updatePreview()">
                        <div style="font-size:0.73rem;color:#94a3b8;margin-top:6px;">
                            <i class="bi bi-lightbulb me-1"></i>Gunakan nama yang jelas dan mudah dikenali
                        </div>
                    </div>

                    {{-- STEP 2: Jenis --}}
                    <div class="p-4 border-bottom" style="border-color:#f1f5f9!important;">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="step-badge">2</div>
                            <span style="font-weight:700;font-size:0.9rem;color:#1e293b;">Jenis Ruangan</span>
                            <a href="{{ route('admin.jenis-ruangan.index') }}"
                                style="font-size:0.72rem;color:#3b82f6;font-weight:600;text-decoration:none;margin-left:auto;">
                                + Tambah Jenis Baru
                            </a>
                        </div>

                        <input type="hidden" name="jenis_ruangan_id" id="jenis_ruangan_id"
                            value="{{ old('jenis_ruangan_id') }}">

                        @php
                            $jenisColors = [
                                [
                                    'bg' => 'linear-gradient(135deg,#3b82f6,#1d4ed8)',
                                    'cls' => 'selected-0',
                                    'badgeBg' => '#eff6ff',
                                    'badgeColor' => '#1d4ed8',
                                    'icon' => 'building',
                                ],
                                [
                                    'bg' => 'linear-gradient(135deg,#22c55e,#15803d)',
                                    'cls' => 'selected-1',
                                    'badgeBg' => '#f0fdf4',
                                    'badgeColor' => '#15803d',
                                    'icon' => 'journal-text',
                                ],
                                [
                                    'bg' => 'linear-gradient(135deg,#8b5cf6,#6d28d9)',
                                    'cls' => 'selected-2',
                                    'badgeBg' => '#faf5ff',
                                    'badgeColor' => '#6d28d9',
                                    'icon' => 'people-fill',
                                ],
                                [
                                    'bg' => 'linear-gradient(135deg,#f59e0b,#d97706)',
                                    'cls' => 'selected-3',
                                    'badgeBg' => '#fffbeb',
                                    'badgeColor' => '#b45309',
                                    'icon' => 'grid-fill',
                                ],
                                [
                                    'bg' => 'linear-gradient(135deg,#ef4444,#dc2626)',
                                    'cls' => 'selected-4',
                                    'badgeBg' => '#fff1f2',
                                    'badgeColor' => '#be123c',
                                    'icon' => 'camera-video',
                                ],
                                [
                                    'bg' => 'linear-gradient(135deg,#06b6d4,#0e7490)',
                                    'cls' => 'selected-5',
                                    'badgeBg' => '#ecfeff',
                                    'badgeColor' => '#0e7490',
                                    'icon' => 'door-open',
                                ],
                            ];
                        @endphp

                        @if ($jenisRuangan->isEmpty())
                            <div class="p-3 rounded-3 text-center"
                                style="background:#fefce8;border:1px dashed #fde047;color:#a16207;font-size:0.82rem;font-weight:600;">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                Belum ada jenis ruangan.
                                <a href="{{ route('admin.jenis-ruangan.index') }}" style="color:#a16207;">Tambahkan dulu</a>
                            </div>
                        @else
                            <div class="row g-3">
                                @foreach ($jenisRuangan as $i => $jenis)
                                    @php $c = $jenisColors[$i % count($jenisColors)]; @endphp
                                    <div class="col-6 col-md-4">
                                        <div class="jenis-card {{ old('jenis_ruangan_id') == $jenis->id ? $c['cls'] : '' }}"
                                            onclick="selectJenis({{ $jenis->id }}, '{{ addslashes($jenis->nama) }}', '{{ $c['cls'] }}', '{{ $c['bg'] }}', '{{ $c['icon'] }}', '{{ $c['badgeBg'] }}', '{{ $c['badgeColor'] }}', this)"
                                            data-id="{{ $jenis->id }}">
                                            <div
                                                style="width:36px;height:36px;border-radius:10px;background:{{ $c['bg'] }};display:flex;align-items:center;justify-content:center;margin-bottom:10px;">
                                                <i class="bi bi-{{ $c['icon'] }} text-white"
                                                    style="font-size:0.95rem;"></i>
                                            </div>
                                            <div style="font-weight:700;font-size:0.85rem;color:#1e293b;">
                                                {{ $jenis->nama }}</div>
                                            <div style="font-size:0.72rem;color:#94a3b8;margin-top:2px;">
                                                {{ $jenis->rooms_count ?? 0 }} ruangan
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @error('jenis_ruangan_id')
                            <div style="color:#ef4444;font-size:0.78rem;margin-top:8px;">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- STEP 3: Kapasitas --}}
                    <div class="p-4 border-bottom" style="border-color:#f1f5f9!important;">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="step-badge">3</div>
                            <span style="font-weight:700;font-size:0.9rem;color:#1e293b;">Kapasitas</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <button type="button" onclick="adjustKapasitas(-5)"
                                style="width:40px;height:40px;border-radius:10px;border:2px solid #e2e8f0;background:white;font-size:1.1rem;font-weight:700;color:#475569;cursor:pointer;flex-shrink:0;">−</button>
                            <div class="input-group flex-grow-1" style="border-radius:12px;overflow:hidden;">
                                <span class="input-group-text"
                                    style="background:#f8fafc;border:2px solid #e2e8f0;border-right:none;color:#64748b;">
                                    <i class="bi bi-people-fill"></i>
                                </span>
                                <input type="number" name="kapasitas" id="kapasitas" value="{{ old('kapasitas', 30) }}"
                                    min="1" max="500"
                                    class="form-control {{ $errors->has('kapasitas') ? 'is-invalid' : '' }}"
                                    style="font-size:1.1rem;font-weight:800;text-align:center;padding:10px;border:2px solid #e2e8f0;border-left:none;border-right:none;"
                                    oninput="updatePreview()">
                                <span class="input-group-text"
                                    style="background:#f8fafc;border:2px solid #e2e8f0;border-left:none;color:#94a3b8;font-size:0.82rem;font-weight:600;">orang</span>
                            </div>
                            <button type="button" onclick="adjustKapasitas(5)"
                                style="width:40px;height:40px;border-radius:10px;border:2px solid #e2e8f0;background:white;font-size:1.1rem;font-weight:700;color:#475569;cursor:pointer;flex-shrink:0;">+</button>
                        </div>
                        <div class="d-flex gap-2 mt-3 flex-wrap">
                            @foreach ([10, 20, 30, 40, 50, 100] as $cap)
                                <button type="button" onclick="setKapasitas({{ $cap }})"
                                    style="padding:4px 12px;border-radius:999px;border:1px solid #e2e8f0;background:#f8fafc;font-size:0.75rem;font-weight:700;color:#64748b;cursor:pointer;">
                                    {{ $cap }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- STEP 4: Fasilitas --}}
                    <div class="p-4 border-bottom" style="border-color:#f1f5f9!important;">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="step-badge">4</div>
                            <span style="font-weight:700;font-size:0.9rem;color:#1e293b;">Fasilitas</span>
                            <span style="font-size:0.72rem;color:#94a3b8;font-weight:600;">(opsional)</span>
                        </div>
                        <input type="hidden" name="fasilitas" id="fasilitas-hidden" value="{{ old('fasilitas') }}">
                        <div id="tag-wrap" onclick="document.getElementById('tag-input').focus()">
                            <input type="text" id="tag-input" placeholder="Ketik lalu Enter...">
                        </div>
                        <div class="d-flex gap-2 mt-3 flex-wrap">
                            @foreach (['Proyektor', 'AC', 'Komputer', 'Whiteboard', 'WiFi', 'Speaker', 'CCTV', 'Papan Tulis'] as $f)
                                <button type="button" onclick="addTag('{{ $f }}')"
                                    style="padding:4px 12px;border-radius:999px;border:1px dashed #cbd5e1;background:white;font-size:0.75rem;font-weight:600;color:#64748b;cursor:pointer;">
                                    + {{ $f }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Preview & Submit --}}
                    <div class="p-4" style="background:#f8fafc;border-radius:0 0 20px 20px;">

                        {{-- Preview card --}}
                        <div id="preview-card"
                            style="background:white;border-radius:14px;border:1px solid #e2e8f0;padding:14px 18px;margin-bottom:16px;display:none;">
                            <div
                                style="font-size:0.68rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:8px;">
                                Preview Ruangan
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <div id="preview-icon"
                                    style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#64748b,#475569);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="bi bi-building text-white" style="font-size:0.9rem;"></i>
                                </div>
                                <div>
                                    <div id="preview-name" style="font-weight:800;font-size:0.95rem;color:#1e293b;">—
                                    </div>
                                    <div class="d-flex align-items-center gap-2 mt-1">
                                        <span id="preview-jenis"
                                            style="font-size:0.72rem;font-weight:700;padding:2px 8px;border-radius:999px;background:#f1f5f9;color:#475569;"></span>
                                        <span id="preview-kapasitas"
                                            style="font-size:0.72rem;color:#94a3b8;font-weight:600;"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <a href="{{ route('admin.rooms.index') }}" class="btn d-inline-flex align-items-center gap-2"
                                style="border-radius:10px;font-size:0.85rem;font-weight:600;background:white;color:#475569;border:1px solid #e2e8f0;padding:9px 18px;text-decoration:none;">
                                <i class="bi bi-x-lg"></i> Batal
                            </a>
                            <button type="submit" class="btn d-inline-flex align-items-center gap-2"
                                style="background:linear-gradient(135deg,#22c55e,#15803d);color:white;border:none;border-radius:12px;font-size:0.88rem;font-weight:700;padding:11px 28px;box-shadow:0 4px 14px rgba(34,197,94,0.35);">
                                <i class="bi bi-building-add"></i> Simpan Ruangan
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        // ── JENIS SELECTION ──
        let currentJenisConfig = null;

        function selectJenis(id, nama, cls, bg, icon, badgeBg, badgeColor, el) {
            document.querySelectorAll('.jenis-card').forEach(c => {
                c.className = 'jenis-card';
            });
            el.classList.add(cls);
            document.getElementById('jenis_ruangan_id').value = id;
            currentJenisConfig = {
                nama,
                bg,
                icon,
                badgeBg,
                badgeColor
            };
            updatePreview();
        }

        // ── KAPASITAS ──
        function adjustKapasitas(delta) {
            const inp = document.getElementById('kapasitas');
            inp.value = Math.max(1, (parseInt(inp.value) || 0) + delta);
            updatePreview();
        }

        function setKapasitas(val) {
            document.getElementById('kapasitas').value = val;
            updatePreview();
        }

        // ── FASILITAS TAGS ──
        @php $initTags = old('fasilitas') ? array_map('trim', explode(',', old('fasilitas'))) : []; @endphp
        let tags = @json($initTags);
        renderTags();

        function renderTags() {
            const wrap = document.getElementById('tag-wrap');
            wrap.querySelectorAll('.fasilitas-tag').forEach(t => t.remove());
            const inp = document.getElementById('tag-input');
            tags.forEach((t, i) => {
                const span = document.createElement('span');
                span.className = 'fasilitas-tag';
                span.innerHTML = `${t} <span class="remove-tag" onclick="removeTag(${i})">×</span>`;
                wrap.insertBefore(span, inp);
            });
            document.getElementById('fasilitas-hidden').value = tags.join(', ');
        }

        function addTag(val) {
            val = val.trim();
            if (val && !tags.includes(val)) {
                tags.push(val);
                renderTags();
            }
        }

        function removeTag(i) {
            tags.splice(i, 1);
            renderTags();
        }

        document.getElementById('tag-input').addEventListener('keydown', function(e) {
            if ((e.key === 'Enter' || e.key === ',') && this.value.trim()) {
                e.preventDefault();
                addTag(this.value.trim());
                this.value = '';
            }
            if (e.key === 'Backspace' && !this.value && tags.length) {
                tags.pop();
                renderTags();
            }
        });

        // ── PREVIEW ──
        function updatePreview() {
            const name = document.getElementById('nama_ruangan').value.trim();
            const kap = document.getElementById('kapasitas').value;
            const card = document.getElementById('preview-card');

            if (!name && !currentJenisConfig) {
                card.style.display = 'none';
                return;
            }
            card.style.display = 'block';

            document.getElementById('preview-name').textContent = name || '—';
            document.getElementById('preview-kapasitas').textContent = kap ? `${kap} orang` : '';

            const jenisEl = document.getElementById('preview-jenis');
            const iconEl = document.getElementById('preview-icon');

            if (currentJenisConfig) {
                jenisEl.textContent = currentJenisConfig.nama;
                jenisEl.style.background = currentJenisConfig.badgeBg;
                jenisEl.style.color = currentJenisConfig.badgeColor;
                iconEl.style.background = currentJenisConfig.bg;
                iconEl.querySelector('i').className = `bi bi-${currentJenisConfig.icon} text-white`;
            }
        }

        document.addEventListener('DOMContentLoaded', updatePreview);
    </script>

@endsection
