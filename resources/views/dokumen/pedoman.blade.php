@extends('layouts.app')
@section('title', 'Pedoman & SOP')
@section('page-title', 'Pedoman dan SOP')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Pedoman dan SOP</h5>
    @if(auth()->user()->canInput())
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-lg me-1"></i>Tambah</button>
    @endif
</div>
<div class="card"><div class="card-body p-0">
    <div class="table-responsive">
    <table class="table table-hover mb-0" style="font-size:13px">
        <thead><tr><th class="ps-3">Nama</th><th>Jenis</th><th>Tahun</th><th>Status</th><th>URL</th>@if(auth()->user()->canInput())<th>Aksi</th>@endif</tr></thead>
        <tbody>
        @forelse($pedoman as $p)
        <tr>
            <td class="ps-3 fw-semibold">{{ $p->nama_pedoman }}</td>
            <td><span class="badge bg-light text-dark" style="font-size:10px;text-transform:uppercase">{{ $p->jenis }}</span></td>
            <td>{{ $p->tahun }}</td>
            <td>
                @if($p->status === 'aktif') <span class="badge bg-success" style="font-size:10px">Aktif</span>
                @elseif($p->status === 'revisi') <span class="badge bg-warning" style="font-size:10px">Revisi</span>
                @else <span class="badge bg-secondary" style="font-size:10px">Tidak Aktif</span> @endif
            </td>
            <td>@if($p->url)<a href="{{ $p->url }}" target="_blank" style="font-size:12px" class="text-primary">Buka</a>@else <span class="text-muted">-</span>@endif</td>
            @if(auth()->user()->canInput())
            <td>
                <button class="btn btn-sm btn-outline-primary py-0 px-2" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $p->id }}"><i class="bi bi-pencil"></i></button>
                <form action="{{ route('pedoman.destroy', $p) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 btn-hapus"><i class="bi bi-trash"></i></button></form>
            </td>
            @endif
        </tr>
        @empty
        <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data pedoman/SOP.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div></div>
@if(auth()->user()->canInput())
<div class="modal fade" id="modalTambah" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
    <form action="{{ route('pedoman.store') }}" method="POST">@csrf
        <div class="modal-header"><h6 class="modal-title fw-semibold">Tambah Pedoman/SOP</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Nama *</label><input type="text" name="nama_pedoman" class="form-control form-control-sm" required></div>
            <div class="row g-2 mb-3">
                <div class="col-4"><label class="form-label fw-semibold" style="font-size:12px">Jenis *</label><select name="jenis" class="form-select form-select-sm"><option value="pedoman">Pedoman</option><option value="sop">SOP</option><option value="panduan">Panduan</option></select></div>
                <div class="col-4"><label class="form-label fw-semibold" style="font-size:12px">Tahun *</label><input type="number" name="tahun" class="form-control form-control-sm" value="{{ now()->year }}" required></div>
                <div class="col-4"><label class="form-label fw-semibold" style="font-size:12px">Status *</label><select name="status" class="form-select form-select-sm"><option value="aktif">Aktif</option><option value="revisi">Revisi</option><option value="tidak_aktif">Tidak Aktif</option></select></div>
            </div>
            <div><label class="form-label fw-semibold" style="font-size:12px">URL</label><input type="url" name="url" class="form-control form-control-sm" placeholder="https://..."></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-sm btn-primary">Simpan</button></div>
    </form>
</div></div></div>
@endif
@endsection
