@extends('layouts.admin')

@section('page_title', 'Tambah User')
@section('page_subtitle', 'Daftarkan akun pengguna baru ke sistem')

@section('content')

    <div>
        <a href="/admin/users" class="d-inline-flex align-items-center gap-2 mb-4 text-decoration-none"
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

        <div class="card">
            <div class="card-header d-flex align-items-center gap-2">
                <div style="width:4px;height:18px;background:linear-gradient(180deg,#3b82f6,#6366f1);border-radius:999px;">
                </div>
                Akun User Baru
            </div>
            <div class="card-body p-4">
                <form action="/admin/users" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.87rem;color:#334155;">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <div class="input-group" style="border-radius:10px;overflow:hidden;">
                            <span class="input-group-text" style="background:#f8fafc;border-color:#e2e8f0;color:#64748b;">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama lengkap user"
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
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com"
                                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                style="font-size:0.9rem;padding:10px 14px;border-color:#e2e8f0;">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.87rem;color:#334155;">
                            Password <span class="text-danger">*</span>
                        </label>
                        <div class="input-group" style="border-radius:10px;overflow:hidden;">
                            <span class="input-group-text" style="background:#f8fafc;border-color:#e2e8f0;color:#64748b;">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input type="password" name="password" id="password" placeholder="Minimal 8 karakter"
                                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                style="font-size:0.9rem;padding:10px 14px;border-color:#e2e8f0;">
                            <button type="button" class="input-group-text"
                                style="background:#f8fafc;border-color:#e2e8f0;cursor:pointer;"
                                onclick="togglePwd('password', this)">
                                <i class="bi bi-eye-fill" style="color:#94a3b8;"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:0.87rem;color:#334155;">
                            Role <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex gap-3">
                            <label class="d-flex align-items-center gap-2 p-3 rounded-3 flex-fill cursor-pointer"
                                style="border:2px solid #e2e8f0;cursor:pointer;transition:border-color 0.15s;"
                                id="role-user-label">
                                <input type="radio" name="role" value="user" class="d-none" id="role-user"
                                    {{ old('role', 'user') == 'user' ? 'checked' : '' }} onchange="selectRole()">
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
                                style="border:2px solid #e2e8f0;cursor:pointer;transition:border-color 0.15s;"
                                id="role-admin-label">
                                <input type="radio" name="role" value="admin" class="d-none" id="role-admin"
                                    {{ old('role') == 'admin' ? 'checked' : '' }} onchange="selectRole()">
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
                            style="background:linear-gradient(135deg,#22c55e,#15803d);color:white;border:none;border-radius:10px;font-size:0.85rem;font-weight:700;padding:9px 22px;">
                            <i class="bi bi-check-lg"></i> Simpan User
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
