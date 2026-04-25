<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register — Booking Ruangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #1d4ed8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 24px 0;
        }

        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.06) 1.5px, transparent 1.5px);
            background-size: 28px 28px;
        }

        .blob-1 {
            position: absolute;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(59, 130, 246, 0.15);
            top: -120px;
            right: -100px;
            filter: blur(70px);
        }

        .blob-2 {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(99, 102, 241, 0.12);
            bottom: -80px;
            left: -60px;
            filter: blur(60px);
        }

        .auth-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 32px 80px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 420px;
            position: relative;
            z-index: 1;
        }

        .auth-header {
            background: linear-gradient(135deg, #0f172a, #1d4ed8);
            border-radius: 24px 24px 0 0;
            padding: 28px 32px 24px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .auth-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.08) 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .auth-icon {
            width: 52px;
            height: 52px;
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            position: relative;
            z-index: 1;
        }

        .auth-body {
            padding: 28px 32px 32px;
        }

        .form-label {
            font-size: 0.87rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .input-group-text {
            background: #f8fafc !important;
            border-color: #e2e8f0 !important;
            color: #94a3b8 !important;
        }

        .form-control {
            border-color: #e2e8f0 !important;
            font-size: 0.9rem !important;
            padding: 10px 14px !important;
        }

        .form-control:focus {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.12) !important;
        }

        .input-group {
            border-radius: 10px;
            overflow: hidden;
        }

        .btn-toggle-pwd {
            background: #f8fafc !important;
            border-color: #e2e8f0 !important;
            cursor: pointer;
        }

        .btn-register {
            background: linear-gradient(135deg, #22c55e, #15803d);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 700;
            padding: 12px;
            transition: opacity 0.2s;
        }

        .btn-register:hover {
            opacity: 0.9;
            color: white;
        }

        /* Password strength bar */
        .strength-bar {
            height: 4px;
            border-radius: 999px;
            background: #e2e8f0;
            margin-top: 8px;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            border-radius: 999px;
            width: 0%;
            transition: width 0.3s, background 0.3s;
        }
    </style>
</head>

<body>
    <div class="blob-1"></div>
    <div class="blob-2"></div>

    <div class="auth-card mx-3">
        {{-- Header --}}
        <div class="auth-header">
            <div class="auth-icon" style="background:transparent;border:none;">
                @if (file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" alt="Logo"
                        style="width:52px;height:52px;object-fit:contain;">
                @else
                    <i class="bi bi-person-plus-fill text-white" style="font-size:1.3rem;"></i>
                @endif
            </div>
            <h5 style="color:white;font-weight:800;margin:0;font-size:1.15rem;position:relative;z-index:1;">Buat Akun
            </h5>
            <p style="color:rgba(255,255,255,0.5);font-size:0.78rem;margin:4px 0 0;position:relative;z-index:1;">
                Daftarkan diri untuk menggunakan sistem booking</p>
        </div>

        {{-- Body --}}
        <div class="auth-body">

            @if ($errors->any())
                <div class="d-flex align-items-start gap-2 p-3 mb-4 rounded-3"
                    style="background:#fee2e2;border:1px solid #fecaca;color:#991b1b;font-size:0.82rem;">
                    <i class="bi bi-exclamation-circle-fill mt-1 flex-shrink-0"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Nama --}}
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="form-control @error('name') is-invalid @enderror" placeholder="Nama lengkap Anda"
                            required autofocus>
                    </div>
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror" placeholder="email@contoh.com"
                            required>
                    </div>
                </div>

                {{-- Password --}}
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimal 8 karakter" required oninput="checkStrength(this.value)">
                        <button type="button" class="input-group-text btn-toggle-pwd"
                            onclick="togglePwd('password','pwd-icon')">
                            <i class="bi bi-eye-fill" id="pwd-icon" style="color:#94a3b8;font-size:0.85rem;"></i>
                        </button>
                    </div>
                    {{-- Strength bar --}}
                    <div class="strength-bar mt-2">
                        <div class="strength-fill" id="strength-fill"></div>
                    </div>
                    <div id="strength-label" style="font-size:0.72rem;color:#94a3b8;margin-top:4px;"></div>
                </div>

                {{-- Konfirmasi Password --}}
                <div class="mb-4">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-shield-lock-fill"></i></span>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" placeholder="Ulangi password" required oninput="checkMatch()">
                        <button type="button" class="input-group-text btn-toggle-pwd"
                            onclick="togglePwd('password_confirmation','pwd-icon-2')">
                            <i class="bi bi-eye-fill" id="pwd-icon-2" style="color:#94a3b8;font-size:0.85rem;"></i>
                        </button>
                    </div>
                    <div id="match-label" style="font-size:0.72rem;margin-top:4px;"></div>
                </div>

                <button type="submit"
                    class="btn btn-register w-100 d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-person-check-fill"></i> Daftar Sekarang
                </button>
            </form>

            <div class="text-center mt-4" style="font-size:0.84rem;color:#64748b;">
                Sudah punya akun?
                <a href="{{ route('login') }}" style="color:#3b82f6;font-weight:700;text-decoration:none;">Masuk di
                    sini</a>
            </div>
        </div>
    </div>

    <script>
        function togglePwd(id, iconId) {
            const input = document.getElementById(id);
            const icon = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.className = 'bi bi-eye-slash-fill';
                icon.style.color = '#3b82f6';
            } else {
                input.type = 'password';
                icon.className = 'bi bi-eye-fill';
                icon.style.color = '#94a3b8';
            }
        }

        function checkStrength(val) {
            const fill = document.getElementById('strength-fill');
            const label = document.getElementById('strength-label');
            let score = 0;
            if (val.length >= 8) score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;

            const levels = [{
                    pct: '0%',
                    color: '',
                    text: ''
                },
                {
                    pct: '25%',
                    color: '#ef4444',
                    text: 'Lemah'
                },
                {
                    pct: '50%',
                    color: '#f59e0b',
                    text: 'Cukup'
                },
                {
                    pct: '75%',
                    color: '#3b82f6',
                    text: 'Kuat'
                },
                {
                    pct: '100%',
                    color: '#22c55e',
                    text: 'Sangat Kuat'
                },
            ];
            const lv = levels[score] || levels[0];
            fill.style.width = lv.pct;
            fill.style.background = lv.color;
            label.textContent = lv.text;
            label.style.color = lv.color;
        }

        function checkMatch() {
            const p1 = document.getElementById('password').value;
            const p2 = document.getElementById('password_confirmation').value;
            const label = document.getElementById('match-label');
            if (!p2) {
                label.textContent = '';
                return;
            }
            if (p1 === p2) {
                label.textContent = '✓ Password cocok';
                label.style.color = '#22c55e';
            } else {
                label.textContent = '✕ Password tidak cocok';
                label.style.color = '#ef4444';
            }
        }
    </script>
</body>

</html>
