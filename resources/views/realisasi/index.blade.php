@extends('layouts.app')
@section('title', 'Realisasi Kinerja')
@section('page-title', 'Data Realisasi Kinerja')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h5 class="fw-bold mb-0">Data Realisasi Kinerja</h5>
        <p class="text-muted mb-0" style="font-size:12px">Triwulan {{ $triwulan }} &middot; Tahun {{ $tahun }}</p>
    </div>
    @if(auth()->user()->canInput())
    <a href="{{ route('realisasi.create', ['triwulan'=>$triwulan,'tahun'=>$tahun]) }}" class="btn btn-primary btn-sm">
        <i class="bi bi-pencil-square me-1"></i>Input Realisasi
    </a>
    @endif
</div>

<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="d-flex gap-2 align-items-center flex-wrap">
            <select name="triwulan" class="form-select form-select-sm" style="width:auto">
                @for($i=1;$i<=4;$i++)
                    <option value="{{ $i }}" {{ $i==$triwulan?'selected':'' }}>TW{{ $i }}</option>
                @endfor
            </select>
            <select name="tahun" class="form-select form-select-sm" style="width:auto">
                @for($y=2023;$y<=now()->year+1;$y++)
                    <option value="{{ $y }}" {{ $y==$tahun?'selected':'' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Terapkan</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">Kode</th>
                        <th>Nama Indikator</th>
                        <th>Target</th>
                        <th>Realisasi</th>
                        <th>Persentase</th>
                        <th>Nilai</th>
                        <th>Status</th>
                        <th>Input Oleh</th>
                        @if(auth()->user()->canInput())
                        <th class="text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($realisasi as $item)
                    <tr>
                        <td class="ps-3">
                            <span class="badge" style="background:#EFF6FF;color:#1D4ED8;font-size:10px">
                                {{ $item->indikator->kode_indikator }}
                            </span>
                        </td>
                        <td>
                            <div style="font-size:13px">{{ $item->indikator->nama_indikator }}</div>
                            <small class="text-muted">{{ $item->indikator->kategori->nama_kategori }}</small>
                        </td>
                        <td style="font-size:13px">{{ number_format($item->target,2) }} {{ $item->indikator->satuan }}</td>
                        <td style="font-size:13px;font-weight:600">{{ number_format($item->realisasi,2) }}</td>
                        <td>
                            @php $pct = $item->persentase; @endphp
                            <span class="{{ $pct>=100?'pct-high':($pct>=75?'pct-mid':'pct-low') }}" style="font-size:13px">{{ $pct }}%</span>
                            <div class="progress mt-1" style="height:4px;width:70px;border-radius:2px">
                                <div class="progress-bar" style="width:{{ min($pct,100) }}%;background:{{ $pct>=100?'#10B981':($pct>=75?'#F59E0B':'#EF4444') }}"></div>
                            </div>
                        </td>
                        <td style="font-size:13px">{{ number_format($item->nilai,2) }}</td>
                        <td>
                            <span class="badge badge-{{ $item->status_verifikasi }}" style="font-size:10px">
                                {{ ucfirst(str_replace('_',' ',$item->status_verifikasi)) }}
                            </span>
                        </td>
                        <td style="font-size:12px;color:#64748B">{{ $item->createdBy?->name ?? '-' }}</td>
                        @if(auth()->user()->canInput())
                        <td class="text-center">
                            <div class="d-flex gap-1 justify-content-center">
                                <a href="{{ route('realisasi.edit', $item) }}" class="btn btn-sm btn-outline-primary py-0 px-2"><i class="bi bi-pencil"></i></a>
                                @if(auth()->user()->isAdmin())
                                <button class="btn btn-sm btn-outline-success py-0 px-2 btn-verif"
                                        data-id="{{ $item->id }}" data-status="terverifikasi" title="Verifikasi">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger py-0 px-2 btn-verif"
                                        data-id="{{ $item->id }}" data-status="ditolak" title="Tolak">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                                @endif
                                <form action="{{ route('realisasi.destroy', $item) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 btn-hapus"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center py-4 text-muted">Belum ada data realisasi periode ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($realisasi->hasPages())
    <div class="card-footer bg-transparent border-0">{{ $realisasi->links() }}</div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.btn-verif').forEach(btn => {
    btn.addEventListener('click', function() {
        const id = this.dataset.id, status = this.dataset.status;
        Swal.fire({
            title: status === 'terverifikasi' ? 'Verifikasi data ini?' : 'Tolak data ini?',
            icon: status === 'terverifikasi' ? 'question' : 'warning',
            showCancelButton: true,
            confirmButtonColor: status === 'terverifikasi' ? '#10B981' : '#EF4444',
            confirmButtonText: 'Ya', cancelButtonText: 'Batal',
        }).then(r => {
            if (r.isConfirmed) $.post(`/realisasi/${id}/verifikasi`, {status}, () => location.reload());
        });
    });
});
</script>
@endpush
