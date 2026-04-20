@extends('layouts.admin')

@section('page_title', 'Edit User')
@section('page_subtitle', 'Perbarui data akun pengguna')

@section('content')

    <div>
        <a href="/admin/users" class="d-inline-flex align-items-center gap-2 mb-4 text-decoration-none"
            style="font-size:0.85rem;font-weight:600;color:#64748b;">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>

        @if (session('success'))
            <div class="d-flex align-items-center gap-2 p-3 mb-4 rounded-3"
                style="background:#dcfce7;border:1px solid #bbf7d0;color:#15803d;font-size:0.85rem;font-weight:600;">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif

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

        {{-- User info banner --}}
        <div class="d-flex align-items-center gap-3 p-3 mb-3 rounded-3"
            style="background:linear-gradient(135deg,#1e293b,#334155);">
            <div
                style="width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:1rem;flex-shrink:0;
            background:{{ $user->role == 'admin' ? 'linear-gradient(135deg,#ef4444,#b91c1c)' : 'linear-gradient(135deg,#3b82f6,#1d4ed8)' }};">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div style="min-width:0;">
                <div style="color:white;font-weight:700;font-size:0.95rem;">{{ $user->name }}</div>
                <div style="color:rgba(255,255,255,0.45);font-size:0.75rem;">{{ $user->email }}</div>
            </div>
            <span class="ms-auto"
                style="font-size:0.72rem;font-weight:700;padding:4px 10px;border-radius:999px;white-space:nowrap;
            background:{{ $user->role == 'admin' ? 'rgba(239,68,68,0.15)' : 'rgba(59,130,246,0.15)' }};
            color:{{ $user->role == 'admin' ? '#fca5a5' : '#93c5fd' }};">
                {{ ucfirst($user->role) }}
            </span>
        </div>

        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <div style="width:4px;height:18px;background:linear-gradient(180deg,#f59e0b,#d97706);border-radius:999px;">
                </div>
                Edit Data User
            </div>
            <div class="card-body p-4">
                <form action="/admin/users/{{ $user->id }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.87rem;color:#334155;">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <div class="input-group" style="border-radius:10px;overflow:hidden;">
                            <span class="input-group-text" style="background:#f8fafc;border-color:#e2e8f0;color:#64748b;">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                style="font-size:0.9rem;padding:10px 14px;border-color:#e2e8f0;">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.87rem;color:#334155;">
                            Email <span class="text-danger">*</span>
                        </label>
                        <div class="input-group" style="border-radius:10px;overflow:hidden;">
                            <span class="input-group-text" style="background:#f8fafc;border-color:#e2e8f0;color:#64748b;">
                                <i class="bi bi-envelope-fill"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                style="font-size:0.9rem;padding:10px 14px;border-color:#e2e8f0;">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.87rem;color:#334155;">Password Baru</label>
                        <div class="input-group" style="border-radius:10px;overflow:hidden;">
                            <span class="input-group-text" style="background:#f8fafc;border-color:#e2e8f0;color:#64748b;">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input type="password" name="password" id="password"
                                placeholder="Kosongkan jika tidak ingin mengubah"
                                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                style="font-size:0.9rem;padding:10px 14px;border-color:#e2e8f0;">
                            <button type="button" class="input-group-text"
                                style="background:#f8fafc;border-color:#e2e8f0;cursor:pointer;"
                                onclick="togglePwd('password', this)">
                                <i class="bi bi-eye-fill" style="color:#94a3b8;"></i>
                            </button>
                        </div>
                        <div style="font-size:0.74rem;color:#94a3b8;margin-top:5px;">
                            <i class="bi bi-info-circle me-1"></i>Biarkan kosong jika tidak ingin mengganti password
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.87rem;color:#334155;">
                            Role <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex gap-3">
                            <label class="d-flex align-items-center gap-2 p-3 rounded-3 flex-fill"
                                style="border:2px solid #e2e8f0;cursor:pointer;" id="role-user-label">
                                <input type="radio" name="role" value="user" class="d-none" id="role-user"
                                    {{ old('role', $user->role) == 'user' ? 'checked' : '' }} onchange="selectRole()">
                                <div
                                    style="width:34px;height:34px;border-radius:9px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="bi bi-person-fill" style="color:#3b82f6;"></i>
                                </div>
                                <div>
                                    <div style="font-weight:700;font-size:0.85rem;color:#334155;">User</div>
                                    <div style="font-size:0.7rem;color:#94a3b8;">Dapat melakukan booking</div>
                                </div>
                            </label>
                            <label class="d-flex align-items-center gap-2 p-3 rounded-3 flex-fill"
                                style="border:2px solid #e2e8f0;cursor:pointer;" id="role-admin-label">
                                <input type="radio" name="role" value="admin" class="d-none" id="role-admin"
                                    {{ old('role', $user->role) == 'admin' ? 'checked' : '' }} onchange="selectRole()">
                                <div
                                    style="width:34px;height:34px;border-radius:9px;background:#fee2e2;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                    <i class="bi bi-shield-fill" style="color:#ef4444;"></i>
                                </div>
                                <div>
                                    <div style="font-weight:700;font-size:0.85rem;color:#334155;">Admin</div>
                                    <div style="font-size:0.7rem;color:#94a3b8;">Akses penuh ke panel</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                        <a href="/admin/users" class="btn"
                            style="border-radius:10px;font-size:0.85rem;font-weight:600;background:#f1f5f9;color:#475569;border:none;padding:9px 18px;">
                            Batal
                        </a>
                        <button type="submit" class="btn d-inline-flex align-items-center gap-2"
                            style="background:linear-gradient(135deg,#f59e0b,#d97706);color:white;border:none;border-radius:10px;font-size:0.85rem;font-weight:700;padding:9px 22px;">
                            <i class="bi bi-check-lg"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePwd(id, btn) {
            const input = document.getElementById(id);
            const icon = btn.querySelector('i');
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

        function selectRole() {
            const isAdmin = document.getElementById('role-admin').checked;
            document.getElementById('role-user-label').style.borderColor = !isAdmin ? '#3b82f6' : '#e2e8f0';
            document.getElementById('role-admin-label').style.borderColor = isAdmin ? '#ef4444' : '#e2e8f0';
        }
        document.addEventListener('DOMContentLoaded', selectRole);
    </script>

@endsection
