@extends('layouts.app')
@section('title', 'Akreditasi')
@section('page-title', 'Data Akreditasi Program Studi')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div><h5 class="fw-bold mb-0">Data Akreditasi</h5><p class="text-muted mb-0" style="font-size:12px">{{ $akreditasi->total() }} program studi</p></div>
    @if(auth()->user()->canInput())
    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-lg me-1"></i>Tambah</button>
    @endif
</div>
<div class="row g-3 mb-3">
    <div class="col-6 col-md-3"><div class="card stat-card" style="border-left-color:#10B981"><div class="card-body py-2"><div class="fw-bold" style="color:#10B981;font-size:22px">{{ $stats['unggul'] }}</div><small class="text-muted">Unggul / A</small></div></div></div>
    <div class="col-6 col-md-3"><div class="card stat-card" style="border-left-color:#2563EB"><div class="card-body py-2"><div class="fw-bold text-primary" style="font-size:22px">{{ $stats['baik_sekali'] }}</div><small class="text-muted">Baik Sekali / B</small></div></div></div>
    <div class="col-6 col-md-3"><div class="card stat-card" style="border-left-color:#F59E0B"><div class="card-body py-2"><div class="fw-bold" style="color:#F59E0B;font-size:22px">{{ $stats['baik'] }}</div><small class="text-muted">Baik / C</small></div></div></div>
    <div class="col-6 col-md-3"><div class="card stat-card" style="border-left-color:#8B5CF6"><div class="card-body py-2"><div class="fw-bold" style="color:#8B5CF6;font-size:22px">{{ $stats['total'] }}</div><small class="text-muted">Total Prodi</small></div></div></div>
</div>
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size:13px">
            <thead><tr><th class="ps-3">Program Studi</th><th>Jenjang</th><th>Status</th><th>Lembaga</th><th>No. SK</th><th>Tgl SK</th><th>Berlaku</th><th>Bukti</th>@if(auth()->user()->canInput())<th>Aksi</th>@endif</tr></thead>
            <tbody>
            @forelse($akreditasi as $item)
            <tr>
                <td class="ps-3 fw-semibold">{{ $item->program_studi }}</td>
                <td><span class="badge bg-light text-dark" style="font-size:10px">{{ $item->jenjang }}</span></td>
                <td>
                    @php $s = strtolower($item->status_akreditasi); @endphp
                    <span class="badge" style="font-size:10px;background:{{ str_contains($s,'unggul')||$s==='a' ? '#D1FAE5' : (str_contains($s,'baik sekali')||$s==='b' ? '#DBEAFE' : '#FEF3C7') }};color:{{ str_contains($s,'unggul')||$s==='a' ? '#065F46' : (str_contains($s,'baik sekali')||$s==='b' ? '#1E40AF' : '#92400E') }}">{{ $item->status_akreditasi }}</span>
                </td>
                <td style="font-size:12px">{{ $item->lembaga_akreditasi }}</td>
                <td style="font-size:11px;color:#64748B">{{ $item->nomor_sk ?? '-' }}</td>
                <td style="font-size:12px">{{ $item->tanggal_sk ? $item->tanggal_sk->format('d/m/Y') : '-' }}</td>
                <td>
                    @if($item->masa_berlaku)
                        <span style="font-size:12px;color:{{ $item->masa_berlaku->isFuture() ? '#10B981' : '#EF4444' }}">
                            {{ $item->masa_berlaku->format('d/m/Y') }}
                        </span>
                    @else - @endif
                </td>
                <td>
                    @if($item->link_bukti)
                    <a href="{{ $item->link_bukti }}" target="_blank" class="btn btn-xs btn-outline-primary py-0 px-2" style="font-size:11px"><i class="bi bi-link-45deg"></i></a>
                    @else <span class="text-muted">-</span> @endif
                </td>
                @if(auth()->user()->canInput())
                <td>
                    <button class="btn btn-sm btn-outline-primary py-0 px-2 btn-edit-akr" data-bs-toggle="modal" data-bs-target="#modalEdit" data-item="{{ json_encode($item) }}"><i class="bi bi-pencil"></i></button>
                    <form action="{{ route('akreditasi.destroy', $item) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 btn-hapus"><i class="bi bi-trash"></i></button></form>
                </td>
                @endif
            </tr>
            @empty
            <tr><td colspan="9" class="text-center py-4 text-muted">Belum ada data akreditasi.</td></tr>
            @endforelse
            </tbody>
        </table>
        </div>
    </div>
    @if($akreditasi->hasPages())
    <div class="card-footer bg-transparent border-0">{{ $akreditasi->links() }}</div>
    @endif
</div>

@if(auth()->user()->canInput())
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('akreditasi.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h6 class="modal-title fw-semibold">Tambah Akreditasi</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-8"><label class="form-label fw-semibold" style="font-size:12px">Program Studi *</label><input type="text" name="program_studi" class="form-control form-control-sm" required></div>
                        <div class="col-4"><label class="form-label fw-semibold" style="font-size:12px">Jenjang *</label><select name="jenjang" class="form-select form-select-sm" required><option>D3</option><option>S1</option><option>S2</option><option>S3</option><option>Profesi</option></select></div>
                        <div class="col-6"><label class="form-label fw-semibold" style="font-size:12px">Status Akreditasi *</label><input type="text" name="status_akreditasi" class="form-control form-control-sm" placeholder="Unggul / Baik Sekali / Baik" required></div>
                        <div class="col-6"><label class="form-label fw-semibold" style="font-size:12px">Lembaga</label><input type="text" name="lembaga_akreditasi" class="form-control form-control-sm" value="BAN-PT"></div>
                        <div class="col-12"><label class="form-label fw-semibold" style="font-size:12px">Nomor SK</label><input type="text" name="nomor_sk" class="form-control form-control-sm"></div>
                        <div class="col-6"><label class="form-label fw-semibold" style="font-size:12px">Tanggal SK</label><input type="date" name="tanggal_sk" class="form-control form-control-sm"></div>
                        <div class="col-6"><label class="form-label fw-semibold" style="font-size:12px">Masa Berlaku</label><input type="date" name="masa_berlaku" class="form-control form-control-sm"></div>
                        <div class="col-12"><label class="form-label fw-semibold" style="font-size:12px">Link Bukti</label><input type="url" name="link_bukti" class="form-control form-control-sm" placeholder="https://..."></div>
                    </div>
                </div>
                <div class="modal-footer"><button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-sm btn-primary">Simpan</button></div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
