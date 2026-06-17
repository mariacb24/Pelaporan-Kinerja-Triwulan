@extends('layouts.app')
@section('title', 'Survei Kepuasan')
@section('page-title', 'Survei & Kepuasan')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Survei Kepuasan</h5>
    @if(auth()->user()->canInput())
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-lg me-1"></i>Tambah Survei</button>
    @endif
</div>
<div class="card"><div class="card-body p-0">
    <div class="table-responsive">
    <table class="table table-hover mb-0" style="font-size:13px">
        <thead><tr><th class="ps-3">Nama Survei</th><th>Tahun</th><th>Triwulan</th><th>Responden</th><th>Hasil</th><th>Keterangan</th>@if(auth()->user()->canInput())<th>Aksi</th>@endif</tr></thead>
        <tbody>
        @forelse($survei as $s)
        <tr>
            <td class="ps-3 fw-semibold">{{ $s->nama_survei }}</td>
            <td>{{ $s->tahun }}</td>
            <td>{{ $s->triwulan ? 'TW'.$s->triwulan : '-' }}</td>
            <td>{{ number_format($s->jumlah_responden) }}</td>
            <td>@if($s->url_hasil)<a href="{{ $s->url_hasil }}" target="_blank" class="text-primary" style="font-size:12px">Lihat Hasil</a>@else <span class="text-muted">-</span>@endif</td>
            <td style="font-size:12px;color:#64748B">{{ $s->keterangan ?? '-' }}</td>
            @if(auth()->user()->canInput())
            <td>
                <button class="btn btn-sm btn-outline-primary py-0 px-2" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $s->id }}"><i class="bi bi-pencil"></i></button>
                <form action="{{ route('survei.destroy', $s) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 btn-hapus"><i class="bi bi-trash"></i></button></form>
            </td>
            @endif
        </tr>
        @empty
        <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data survei.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div></div>
@if(auth()->user()->canInput())
<div class="modal fade" id="modalTambah" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
    <form action="{{ route('survei.store') }}" method="POST">@csrf
        <div class="modal-header"><h6 class="modal-title fw-semibold">Tambah Survei</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Nama Survei *</label><input type="text" name="nama_survei" class="form-control form-control-sm" required></div>
            <div class="row g-2 mb-3">
                <div class="col-4"><label class="form-label fw-semibold" style="font-size:12px">Tahun *</label><input type="number" name="tahun" class="form-control form-control-sm" value="{{ now()->year }}" required></div>
                <div class="col-4"><label class="form-label fw-semibold" style="font-size:12px">Triwulan</label><select name="triwulan" class="form-select form-select-sm"><option value="">-</option><option>1</option><option>2</option><option>3</option><option>4</option></select></div>
                <div class="col-4"><label class="form-label fw-semibold" style="font-size:12px">Responden</label><input type="number" name="jumlah_responden" class="form-control form-control-sm" value="0"></div>
            </div>
            <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">URL Hasil</label><input type="url" name="url_hasil" class="form-control form-control-sm" placeholder="https://..."></div>
            <div><label class="form-label fw-semibold" style="font-size:12px">Keterangan</label><textarea name="keterangan" class="form-control form-control-sm" rows="2"></textarea></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-sm btn-primary">Simpan</button></div>
    </form>
</div></div></div>
@endif
@endsection
