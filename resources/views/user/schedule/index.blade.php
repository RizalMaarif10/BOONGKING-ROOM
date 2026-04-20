@extends('layouts.user')

@section('title', 'Jadwal Ruangan')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h5 class="fw-bold text-dark mb-0">Jadwal Penggunaan Ruangan</h5>
            <small class="text-muted">Lihat ketersediaan ruangan sebelum melakukan booking</small>
        </div>
        <a href="/booking" class="btn d-inline-flex align-items-center gap-2"
            style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);color:white;border:none;border-radius:10px;font-weight:600;font-size:0.82rem;padding:8px 16px;text-decoration:none;">
            <i class="bi bi-calendar2-plus"></i> Booking Ruangan
        </a>
    </div>

    <div class="row g-4">

        {{-- ── CALENDAR ── --}}
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <div
                        style="width:4px;height:18px;background:linear-gradient(180deg,#3b82f6,#6366f1);border-radius:999px;">
                    </div>
                    Kalender Booking
                </div>
                <div class="card-body p-4">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        {{-- ── SIDEBAR ── --}}
        <div class="col-lg-3 d-flex flex-column gap-3">

            {{-- Legend --}}
            <div class="card">
                <div class="card-header d-flex align-items-center gap-2">
                    <div
                        style="width:4px;height:18px;background:linear-gradient(180deg,#f59e0b,#d97706);border-radius:999px;">
                    </div>
                    Keterangan Warna
                </div>
                <div class="card-body p-3 d-flex flex-column gap-2">
                    @foreach ([['color' => '#3b82f6', 'label' => 'Laboratorium'], ['color' => '#22c55e', 'label' => 'Ruang Kelas'], ['color' => '#8b5cf6', 'label' => 'Ruang Sidang'], ['color' => '#f59e0b', 'label' => 'Lainnya']] as $l)
                        <div class="d-flex align-items-center gap-2">
                            <span
                                style="width:12px;height:12px;border-radius:4px;background:{{ $l['color'] }};flex-shrink:0;display:inline-block;"></span>
                            <span style="font-size:0.82rem;color:#334155;font-weight:600;">{{ $l['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Event detail card --}}
            <div class="card" id="event-detail-card" style="display:none!important;">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <div
                            style="width:4px;height:18px;background:linear-gradient(180deg,#22c55e,#15803d);border-radius:999px;">
                        </div>
                        Detail Booking
                    </div>
                    <button onclick="closeDetail()"
                        style="background:none;border:none;cursor:pointer;color:#94a3b8;padding:2px;">
                        <i class="bi bi-x-lg" style="font-size:0.85rem;"></i>
                    </button>
                </div>
                <div class="card-body p-3" id="event-detail-body"></div>
            </div>

            {{-- Tips --}}
            <div class="card">
                <div class="card-body p-3">
                    <p
                        style="font-size:0.7rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:10px;">
                        Tips</p>
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-hand-index-fill mt-1 flex-shrink-0"
                                style="color:#3b82f6;font-size:0.75rem;"></i>
                            <span style="font-size:0.78rem;color:#64748b;line-height:1.5;">Klik event pada kalender untuk
                                melihat detail booking.</span>
                        </div>
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-arrow-left-right mt-1 flex-shrink-0"
                                style="color:#3b82f6;font-size:0.75rem;"></i>
                            <span style="font-size:0.78rem;color:#64748b;line-height:1.5;">Navigasi bulan menggunakan tombol
                                ◀ ▶ di atas kalender.</span>
                        </div>
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-calendar2-check mt-1 flex-shrink-0"
                                style="color:#22c55e;font-size:0.75rem;"></i>
                            <span style="font-size:0.78rem;color:#64748b;line-height:1.5;">Hanya booking yang sudah
                                <strong>approved</strong> yang ditampilkan.</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ── EVENT DETAIL MODAL (mobile) ── --}}
    <div id="event-modal"
        style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.5);backdrop-filter:blur(4px);"
        onclick="if(event.target===this)closeModal()">
        <div
            style="position:absolute;bottom:0;left:0;right:0;background:white;border-radius:20px 20px 0 0;padding:24px;max-height:70vh;overflow-y:auto;">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="fw-bold mb-0" style="color:#1e293b;">Detail Booking</h6>
                <button onclick="closeModal()"
                    style="width:30px;height:30px;border-radius:8px;background:#f1f5f9;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;">
                    <i class="bi bi-x-lg" style="font-size:0.8rem;color:#64748b;"></i>
                </button>
            </div>
            <div id="modal-detail-body"></div>
        </div>
    </div>

    {{-- ── FULLCALENDAR ── --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <style>
        /* Override FullCalendar default styles */
        .fc {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 0.85rem;
        }

        .fc .fc-toolbar-title {
            font-size: 1rem !important;
            font-weight: 800 !important;
            color: #1e293b !important;
        }

        .fc .fc-button {
            background: #f1f5f9 !important;
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
            font-weight: 700 !important;
            font-size: 0.78rem !important;
            border-radius: 8px !important;
            padding: 6px 12px !important;
            box-shadow: none !important;
            transition: all 0.15s !important;
        }

        .fc .fc-button:hover {
            background: #e2e8f0 !important;
        }

        .fc .fc-button-primary:not(:disabled).fc-button-active {
            background: #1e293b !important;
            border-color: #1e293b !important;
            color: white !important;
        }

        .fc .fc-col-header-cell-cushion {
            font-size: 0.72rem !important;
            font-weight: 700 !important;
            color: #64748b !important;
            text-transform: uppercase !important;
            letter-spacing: 0.06em !important;
            text-decoration: none !important;
        }

        .fc .fc-daygrid-day-number {
            font-size: 0.82rem !important;
            font-weight: 600 !important;
            color: #334155 !important;
            text-decoration: none !important;
        }

        .fc .fc-day-today {
            background: #eff6ff !important;
        }

        .fc .fc-day-today .fc-daygrid-day-number {
            color: #1d4ed8 !important;
            font-weight: 800 !important;
        }

        .fc .fc-event {
            border: none !important;
            border-radius: 6px !important;
            font-size: 0.72rem !important;
            font-weight: 700 !important;
            cursor: pointer !important;
            padding: 2px 6px !important;
        }

        .fc .fc-event:hover {
            opacity: 0.85 !important;
        }

        .fc .fc-daygrid-event-dot {
            display: none !important;
        }

        .fc th {
            border-color: #f1f5f9 !important;
        }

        .fc td {
            border-color: #f1f5f9 !important;
        }

        .fc .fc-scrollgrid {
            border: none !important;
        }

        .fc .fc-scrollgrid-section>td {
            border: none !important;
        }
    </style>

    <script>
        const isMobile = () => window.innerWidth < 992;

        function buildDetailHTML(props) {
            const rows = [{
                    icon: 'building',
                    color: '#3b82f6',
                    label: 'Ruangan',
                    val: props.ruangan
                },
                {
                    icon: 'person-fill',
                    color: '#22c55e',
                    label: 'Pemohon',
                    val: props.user
                },
                {
                    icon: 'clock-fill',
                    color: '#f59e0b',
                    label: 'Jam',
                    val: props.jam
                },
                {
                    icon: 'card-text',
                    color: '#8b5cf6',
                    label: 'Keperluan',
                    val: props.keperluan
                },
            ];
            return rows.map(r => `
        <div class="d-flex align-items-start gap-3 mb-3">
            <div style="width:32px;height:32px;border-radius:8px;background:${r.color}20;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="bi bi-${r.icon}" style="color:${r.color};font-size:0.8rem;"></i>
            </div>
            <div>
                <div style="font-size:0.68rem;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.08em;">${r.label}</div>
                <div style="font-size:0.88rem;font-weight:600;color:#1e293b;margin-top:2px;">${r.val || '—'}</div>
            </div>
        </div>`).join('');
        }

        function closeDetail() {
            document.getElementById('event-detail-card').style.setProperty('display', 'none', 'important');
        }

        function closeModal() {
            document.getElementById('event-modal').style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 600,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                },
                locale: 'id',
                events: '/schedule/data',
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                },
                eventClick: function(info) {
                    const props = info.event.extendedProps;
                    const html = buildDetailHTML(props);

                    if (isMobile()) {
                        document.getElementById('modal-detail-body').innerHTML = html;
                        document.getElementById('event-modal').style.display = 'block';
                    } else {
                        document.getElementById('event-detail-body').innerHTML = html;
                        document.getElementById('event-detail-card').style.setProperty('display',
                            'block', 'important');
                    }
                },
                eventDidMount: function(info) {
                    info.el.title = info.event.extendedProps.ruangan + ' — ' + info.event.extendedProps
                        .jam;
                },
                dayMaxEvents: 3,
                moreLinkText: val => `+${val} lagi`,
            });

            calendar.render();
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') {
                closeDetail();
                closeModal();
            }
        });
    </script>

@endsection
