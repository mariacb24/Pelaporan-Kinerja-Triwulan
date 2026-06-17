@extends('layouts.app')
@section('title', 'Kelola User')
@section('page-title', 'Manajemen Pengguna')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Kelola Pengguna</h5>
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-person-plus me-1"></i>Tambah User</button>
</div>
<div class="row g-3 mb-3">
    <div class="col-4"><div class="card stat-card" style="border-left-color:#2563EB"><div class="card-body py-2"><div class="fw-bold text-primary" style="font-size:22px">{{ $stats['total'] }}</div><small class="text-muted">Total User</small></div></div></div>
    <div class="col-4"><div class="card stat-card" style="border-left-color:#10B981"><div class="card-body py-2"><div class="fw-bold" style="color:#10B981;font-size:22px">{{ $stats['aktif'] }}</div><small class="text-muted">Aktif</small></div></div></div>
    <div class="col-4"><div class="card stat-card" style="border-left-color:#EF4444"><div class="card-body py-2"><div class="fw-bold" style="color:#EF4444;font-size:22px">{{ $stats['nonaktif'] }}</div><small class="text-muted">Nonaktif</small></div></div></div>
</div>
<div class="card mb-3"><div class="card-body py-2">
    <form method="GET" class="d-flex gap-2">
        <input name="search" class="form-control form-control-sm" style="width:220px" placeholder="Cari nama/email..." value="{{ request('search') }}">
        <button class="btn btn-primary btn-sm">Cari</button>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
    </form>
</div></div>
<div class="card"><div class="card-body p-0">
    <div class="table-responsive">
    <table class="table table-hover mb-0" style="font-size:13px">
        <thead><tr><th class="ps-3">Nama</th><th>Email</th><th>Role</th><th>Status</th><th>Bergabung</th><th class="text-center">Aksi</th></tr></thead>
        <tbody>
        @forelse($users as $u)
        <tr>
            <td class="ps-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="avatar" style="width:28px;height:28px;font-size:11px">{{ strtoupper(substr($u->name,0,1)) }}</div>
                    <span class="fw-semibold">{{ $u->name }}</span>
                </div>
            </td>
            <td style="color:#64748B">{{ $u->email }}</td>
            <td>
                @php $rc = ['admin'=>'FEE2E2,991B1B','operator_bpm'=>'DBEAFE,1E40AF','pimpinan'=>'D1FAE5,065F46']; $c = $rc[$u->role->name] ?? 'F1F5F9,374151'; [$bg,$fg] = explode(',',$c); @endphp
                <span class="badge" style="background:#{{ $bg }};color:#{{ $fg }};font-size:10px">{{ $u->role->display_name }}</span>
            </td>
            <td>
                @if($u->is_active) <span class="badge bg-success" style="font-size:10px">Aktif</span>
                @else <span class="badge bg-secondary" style="font-size:10px">Nonaktif</span> @endif
            </td>
            <td style="font-size:12px;color:#94A3B8">{{ $u->created_at->format('d/m/Y') }}</td>
            <td class="text-center">
                <div class="d-flex gap-1 justify-content-center">
                    <button class="btn btn-sm btn-outline-primary py-0 px-2" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $u->id }}"><i class="bi bi-pencil"></i></button>
                    <form action="{{ route('users.toggle', $u) }}" method="POST" class="d-inline">@csrf
                        <button type="submit" class="btn btn-sm {{ $u->is_active ? 'btn-outline-warning' : 'btn-outline-success' }} py-0 px-2" title="{{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                            <i class="bi bi-{{ $u->is_active ? 'pause' : 'play' }}-circle"></i>
                        </button>
                    </form>
                    @if($u->id !== auth()->id())
                    <form action="{{ route('users.destroy', $u) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 btn-hapus"><i class="bi bi-trash"></i></button></form>
                    @endif
                </div>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada user.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div>
@if($users->hasPages())<div class="card-footer bg-transparent border-0">{{ $users->links() }}</div>@endif
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
    <form action="{{ route('users.store') }}" method="POST">@csrf
        <div class="modal-header"><h6 class="modal-title fw-semibold">Tambah User</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Nama Lengkap *</label><input type="text" name="name" class="form-control form-control-sm" required></div>
            <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Email *</label><input type="email" name="email" class="form-control form-control-sm" required></div>
            <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Role *</label>
                <select name="role_id" class="form-select form-select-sm" required>
                    @foreach($roles as $r)<option value="{{ $r->id }}">{{ $r->display_name }}</option>@endforeach
                </select>
            </div>
            <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Password *</label><input type="password" name="password" class="form-control form-control-sm" required></div>
            <div><label class="form-label fw-semibold" style="font-size:12px">Konfirmasi Password *</label><input type="password" name="password_confirmation" class="form-control form-control-sm" required></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-sm btn-primary">Tambah</button></div>
    </form>
</div></div></div>

<!-- Modal Edit per User -->
@foreach($users as $u)
<div class="modal fade" id="modalEdit{{ $u->id }}" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
    <form action="{{ route('users.update', $u) }}" method="POST">@csrf @method('PUT')
        <div class="modal-header"><h6 class="modal-title fw-semibold">Edit User: {{ $u->name }}</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Nama</label><input type="text" name="name" class="form-control form-control-sm" value="{{ $u->name }}" required></div>
            <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Email</label><input type="email" name="email" class="form-control form-control-sm" value="{{ $u->email }}" required></div>
            <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Role</label>
                <select name="role_id" class="form-select form-select-sm">
                    @foreach($roles as $r)<option value="{{ $r->id }}" {{ $r->id==$u->role_id?'selected':'' }}>{{ $r->display_name }}</option>@endforeach
                </select>
            </div>
            <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Password Baru <small class="text-muted">(kosongkan jika tidak diubah)</small></label><input type="password" name="password" class="form-control form-control-sm"></div>
            <div><label class="form-label fw-semibold" style="font-size:12px">Konfirmasi Password</label><input type="password" name="password_confirmation" class="form-control form-control-sm"></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-sm btn-primary">Simpan</button></div>
    </form>
</div></div></div>
@endforeach
@endsection
