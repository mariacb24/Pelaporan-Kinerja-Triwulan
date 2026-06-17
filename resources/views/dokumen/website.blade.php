@extends('layouts.app')
@section('title', 'Dokumen Website')
@section('page-title', 'Dokumen Website')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Dokumen Website</h5>
    @if(auth()->user()->canInput())
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-lg me-1"></i>Tambah</button>
    @endif
</div>
<div class="card mb-3"><div class="card-body py-2">
    <form method="GET" class="d-flex gap-2 flex-wrap">
        <input name="search" class="form-control form-control-sm" style="width:200px" placeholder="Cari..." value="{{ request('search') }}">
        <select name="status" class="form-select form-select-sm" style="width:160px"><option value="">Semua Status</option><option value="tersedia" {{ request('status')=='tersedia'?'selected':'' }}>Tersedia</option><option value="tidak_tersedia" {{ request('status')=='tidak_tersedia'?'selected':'' }}>Tidak Tersedia</option></select>
        <button class="btn btn-primary btn-sm">Filter</button>
        <a href="{{ route('dokumen.website.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
    </form>
</div></div>
<div class="card"><div class="card-body p-0">
    <div class="table-responsive">
    <table class="table table-hover mb-0" style="font-size:13px">
        <thead><tr><th class="ps-3">Nama Dokumen</th><th>Kategori</th><th>Tahun</th><th>Status</th><th>URL</th>@if(auth()->user()->canInput())<th>Aksi</th>@endif</tr></thead>
        <tbody>
        @forelse($dokumen as $d)
        <tr>
            <td class="ps-3 fw-semibold">{{ $d->nama_dokumen }}</td>
            <td style="font-size:12px">{{ $d->kategori }}</td>
            <td>{{ $d->tahun }}</td>
            <td>
                @if($d->status === 'tersedia')
                <span class="badge badge-tersedia" style="font-size:10px">Tersedia</span>
                @else
                <span class="badge badge-tidak" style="font-size:10px">Tidak Tersedia</span>
                @endif
            </td>
            <td>
                @if($d->url_dokumen)
                <a href="{{ $d->url_dokumen }}" target="_blank" class="text-primary" style="font-size:12px"><i class="bi bi-box-arrow-up-right me-1"></i>Buka</a>
                @else <span class="text-muted">-</span> @endif
            </td>
            @if(auth()->user()->canInput())
            <td>
                <button class="btn btn-sm btn-outline-primary py-0 px-2" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $d->id }}"><i class="bi bi-pencil"></i></button>
                <form action="{{ route('dokumen.website.destroy', $d) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 btn-hapus"><i class="bi bi-trash"></i></button></form>
            </td>
            @endif
        </tr>
        @empty
        <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data dokumen.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div>
@if($dokumen->hasPages())<div class="card-footer bg-transparent border-0">{{ $dokumen->links() }}</div>@endif
</div>

@if(auth()->user()->canInput())
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <form action="{{ route('dokumen.website.store') }}" method="POST">@csrf
            <div class="modal-header"><h6 class="modal-title fw-semibold">Tambah Dokumen Website</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Nama Dokumen *</label><input type="text" name="nama_dokumen" class="form-control form-control-sm" required></div>
                <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Kategori *</label><input type="text" name="kategori" class="form-control form-control-sm" required></div>
                <div class="row g-2">
                    <div class="col-6"><label class="form-label fw-semibold" style="font-size:12px">Tahun *</label><input type="number" name="tahun" class="form-control form-control-sm" value="{{ now()->year }}" required></div>
                    <div class="col-6"><label class="form-label fw-semibold" style="font-size:12px">Status *</label><select name="status" class="form-select form-select-sm"><option value="tersedia">Tersedia</option><option value="tidak_tersedia">Tidak Tersedia</option></select></div>
                </div>
                <div class="mt-3"><label class="form-label fw-semibold" style="font-size:12px">URL Dokumen</label><input type="url" name="url_dokumen" class="form-control form-control-sm" placeholder="https://..."></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-sm btn-primary">Simpan</button></div>
        </form>
    </div></div>
</div>
@foreach($dokumen as $d)
<div class="modal fade" id="modalEdit{{ $d->id }}" tabindex="-1">
    <div class="modal-dialog"><div class="modal-content">
        <form action="{{ route('dokumen.website.update', $d) }}" method="POST">@csrf @method('PUT')
            <div class="modal-header"><h6 class="modal-title fw-semibold">Edit Dokumen</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body">
                <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Nama Dokumen</label><input type="text" name="nama_dokumen" class="form-control form-control-sm" value="{{ $d->nama_dokumen }}" required></div>
                <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Kategori</label><input type="text" name="kategori" class="form-control form-control-sm" value="{{ $d->kategori }}" required></div>
                <div class="row g-2">
                    <div class="col-6"><label class="form-label fw-semibold" style="font-size:12px">Tahun</label><input type="number" name="tahun" class="form-control form-control-sm" value="{{ $d->tahun }}" required></div>
                    <div class="col-6"><label class="form-label fw-semibold" style="font-size:12px">Status</label><select name="status" class="form-select form-select-sm"><option value="tersedia" {{ $d->status=='tersedia'?'selected':'' }}>Tersedia</option><option value="tidak_tersedia" {{ $d->status=='tidak_tersedia'?'selected':'' }}>Tidak Tersedia</option></select></div>
                </div>
                <div class="mt-3"><label class="form-label fw-semibold" style="font-size:12px">URL Dokumen</label><input type="url" name="url_dokumen" class="form-control form-control-sm" value="{{ $d->url_dokumen }}"></div>
            </div>
            <div class="modal-footer"><button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-sm btn-primary">Simpan</button></div>
        </form>
    </div></div>
</div>
@endforeach
@endif
@endsection
