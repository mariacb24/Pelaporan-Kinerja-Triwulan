@extends('layouts.app')
@section('title', 'Dokumen SPMI')
@section('page-title', 'Dokumen SPMI')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Dokumen SPMI</h5>
    @if(auth()->user()->canInput())
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-lg me-1"></i>Tambah</button>
    @endif
</div>
<div class="card"><div class="card-body p-0">
    <div class="table-responsive">
    <table class="table table-hover mb-0" style="font-size:13px">
        <thead><tr><th class="ps-3">Nama Dokumen</th><th>Kategori</th><th>Tahun</th><th>Status</th><th>Link</th>@if(auth()->user()->canInput())<th>Aksi</th>@endif</tr></thead>
        <tbody>
        @forelse($dokumen as $d)
        <tr>
            <td class="ps-3 fw-semibold">{{ $d->nama_dokumen }}</td>
            <td style="font-size:12px">{{ $d->kategori }}</td>
            <td>{{ $d->tahun }}</td>
            <td><span class="badge badge-{{ $d->status }}" style="font-size:10px">{{ ucfirst(str_replace('_',' ',$d->status)) }}</span></td>
            <td>
                @if($d->link_drive)
                <a href="{{ $d->link_drive }}" target="_blank" class="text-primary" style="font-size:12px"><i class="bi bi-google me-1"></i>Drive</a>
                @else <span class="text-muted">-</span> @endif
            </td>
            @if(auth()->user()->canInput())
            <td>
                <button class="btn btn-sm btn-outline-primary py-0 px-2" onclick="editSpmi({{ $d->id }}, '{{ $d->nama_dokumen }}', '{{ $d->kategori }}', {{ $d->tahun }}, '{{ $d->status }}', '{{ $d->link_drive }}')"><i class="bi bi-pencil"></i></button>
                <form action="{{ route('dokumen.spmi.destroy', $d) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 btn-hapus"><i class="bi bi-trash"></i></button></form>
            </td>
            @endif
        </tr>
        @empty
        <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data dokumen SPMI.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div></div>
@if(auth()->user()->canInput())
<div class="modal fade" id="modalTambah" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
    <form action="{{ route('dokumen.spmi.store') }}" method="POST">@csrf
        <div class="modal-header"><h6 class="modal-title fw-semibold">Tambah Dokumen SPMI</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Nama Dokumen *</label><input type="text" name="nama_dokumen" class="form-control form-control-sm" required></div>
            <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Kategori *</label><input type="text" name="kategori" class="form-control form-control-sm" required></div>
            <div class="row g-2 mb-3">
                <div class="col-6"><label class="form-label fw-semibold" style="font-size:12px">Tahun *</label><input type="number" name="tahun" class="form-control form-control-sm" value="{{ now()->year }}" required></div>
                <div class="col-6"><label class="form-label fw-semibold" style="font-size:12px">Status *</label><select name="status" class="form-select form-select-sm"><option value="lengkap">Lengkap</option><option value="proses">Proses</option><option value="tidak_lengkap">Tidak Lengkap</option></select></div>
            </div>
            <div><label class="form-label fw-semibold" style="font-size:12px">Link Google Drive</label><input type="url" name="link_drive" class="form-control form-control-sm" placeholder="https://drive.google.com/..."></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-sm btn-primary">Simpan</button></div>
    </form>
</div></div></div>
@endif
@endsection
