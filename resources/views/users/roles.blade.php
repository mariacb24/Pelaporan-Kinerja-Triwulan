@extends('layouts.app')
@section('title', 'Role')
@section('page-title', 'Kelola Role')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Kelola Role</h5>
</div>
<div class="card"><div class="card-body p-0">
    <div class="table-responsive">
    <table class="table table-hover mb-0" style="font-size:13px">
        <thead><tr><th class="ps-3">Role</th><th>Nama Tampil</th><th>Deskripsi</th><th>Jumlah User</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($roles as $r)
        <tr>
            <td class="ps-3"><code style="font-size:12px">{{ $r->name }}</code></td>
            <td class="fw-semibold">{{ $r->display_name }}</td>
            <td style="font-size:12px;color:#64748B">{{ $r->description }}</td>
            <td><span class="badge bg-light text-dark">{{ $r->users_count }} user</span></td>
            <td>
                <button class="btn btn-sm btn-outline-primary py-0 px-2" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $r->id }}"><i class="bi bi-pencil"></i></button>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center py-4 text-muted">Tidak ada role.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div></div>
@foreach($roles as $r)
<div class="modal fade" id="modalEdit{{ $r->id }}" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
    <form action="{{ route('roles.update', $r) }}" method="POST">@csrf @method('PUT')
        <div class="modal-header"><h6 class="modal-title fw-semibold">Edit Role: {{ $r->name }}</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Nama Tampil</label><input type="text" name="display_name" class="form-control form-control-sm" value="{{ $r->display_name }}" required></div>
            <div><label class="form-label fw-semibold" style="font-size:12px">Deskripsi</label><textarea name="description" class="form-control form-control-sm" rows="2">{{ $r->description }}</textarea></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-sm btn-primary">Simpan</button></div>
    </form>
</div></div></div>
@endforeach
@endsection
