@extends('layouts.admin')

@section('page_title', 'Manajemen User')
@section('page_subtitle', 'Kelola akun pengguna sistem booking')

@section('content')

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h5 class="fw-bold text-dark mb-0">Daftar User</h5>
            <small class="text-muted">{{ count($users) }} akun terdaftar</small>
        </div>
        <a href="/admin/users/create" class="btn d-inline-flex align-items-center gap-2"
            style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);color:white;border:none;border-radius:10px;font-weight:600;font-size:0.85rem;padding:9px 18px;">
            <i class="bi bi-person-plus-fill"></i> Tambah User
        </a>
    </div>

    @if (session('success'))
        <div class="d-flex align-items-center gap-2 p-3 mb-4 rounded-3"
            style="background:#dcfce7;border:1px solid #bbf7d0;color:#15803d;font-size:0.85rem;font-weight:600;">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th style="width:48px;">No</th>
                        <th>Pengguna</th>
                        <th class="d-none d-md-table-cell">Email</th>
                        <th>Role</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr>
                            <td><span style="font-size:0.75rem;color:#94a3b8;font-weight:700;">{{ $index + 1 }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div
                                        style="width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;color:white;font-weight:700;font-size:0.82rem;flex-shrink:0;
                                background:{{ $user->role == 'admin' ? 'linear-gradient(135deg,#ef4444,#b91c1c)' : 'linear-gradient(135deg,#3b82f6,#1d4ed8)' }};">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div style="font-weight:700;color:#1e293b;font-size:0.87rem;">{{ $user->name }}
                                        </div>
                                        <div class="d-md-none" style="color:#94a3b8;font-size:0.72rem;">{{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell">
                                <a href="mailto:{{ $user->email }}"
                                    style="color:#64748b;font-size:0.85rem;text-decoration:none;">
                                    {{ $user->email }}
                                </a>
                            </td>
                            <td>
                                @if ($user->role == 'admin')
                                    <span
                                        style="background:#fee2e2;color:#991b1b;border:1px solid #fecaca;font-size:0.72rem;font-weight:700;padding:4px 10px;border-radius:999px;">
                                        <i class="bi bi-shield-fill me-1"></i>Admin
                                    </span>
                                @else
                                    <span
                                        style="background:#f1f5f9;color:#475569;border:1px solid #e2e8f0;font-size:0.72rem;font-weight:700;padding:4px 10px;border-radius:999px;">
                                        <i class="bi bi-person-fill me-1"></i>User
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="/admin/users/{{ $user->id }}/edit"
                                        class="d-inline-flex align-items-center gap-1 px-3 py-1"
                                        style="background:#fef3c7;color:#92400e;border:1px solid #fde68a;border-radius:8px;font-size:0.75rem;font-weight:700;text-decoration:none;">
                                        <i class="bi bi-pencil-fill"></i> Edit
                                    </a>
                                    <form action="/admin/users/{{ $user->id }}" method="POST" class="m-0"
                                        onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="d-inline-flex align-items-center gap-1 px-3 py-1"
                                            style="background:#fee2e2;color:#991b1b;border:1px solid #fecaca;border-radius:8px;font-size:0.75rem;font-weight:700;cursor:pointer;">
                                            <i class="bi bi-trash-fill"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-people d-block mb-2" style="font-size:2.2rem;color:#cbd5e1;"></i>
                                <span style="color:#94a3b8;font-size:0.85rem;">Belum ada user terdaftar</span><br>
                                <a href="/admin/users/create" style="font-size:0.82rem;font-weight:700;color:#3b82f6;">+
                                    Tambah User</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if (method_exists($users, 'hasPages') && $users->hasPages())
            <div class="card-footer bg-white border-top-0 py-3">{{ $users->links() }}</div>
        @endif
    </div>

@endsection
