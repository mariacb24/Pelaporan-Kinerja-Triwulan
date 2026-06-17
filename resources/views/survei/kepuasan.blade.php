@extends('layouts.app')
@section('title', 'Kepuasan Mahasiswa')
@section('page-title', 'Kepuasan Mahasiswa')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h5 class="fw-bold mb-0">Kepuasan Mahasiswa {{ $tahun }}</h5>
    <div class="d-flex gap-2">
        <form method="GET" class="d-flex gap-2">
            <select name="tahun" class="form-select form-select-sm" style="width:auto">
                @for($y=2023;$y<=now()->year+1;$y++)<option value="{{ $y }}" {{ $y==$tahun?'selected':'' }}>{{ $y }}</option>@endfor
            </select>
            <button class="btn btn-sm btn-primary">Terapkan</button>
        </form>
        @if(auth()->user()->canInput())
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambah"><i class="bi bi-plus-lg me-1"></i>Tambah</button>
        @endif
    </div>
</div>
@if($kepuasan->isNotEmpty())
<div class="card mb-4"><div class="card-body">
    <div class="card-header-bpm">Grafik Skor Kepuasan</div>
    <canvas id="chartKepuasan" style="max-height:250px"></canvas>
</div></div>
@endif
<div class="card"><div class="card-body p-0">
    <div class="table-responsive">
    <table class="table mb-0" style="font-size:13px">
        <thead><tr><th class="ps-3">Aspek</th><th>Tidak Puas</th><th>Kurang Puas</th><th>Puas</th><th>Sangat Puas</th><th>Skor Rata</th>@if(auth()->user()->canInput())<th>Aksi</th>@endif</tr></thead>
        <tbody>
        @forelse($kepuasan as $k)
        <tr>
            <td class="ps-3 fw-semibold">{{ $k->aspek }}</td>
            <td style="color:#EF4444">{{ $k->tidak_puas }}%</td>
            <td style="color:#F59E0B">{{ $k->kurang_puas }}%</td>
            <td style="color:#10B981">{{ $k->puas }}%</td>
            <td style="color:#2563EB">{{ $k->sangat_puas }}%</td>
            <td>
                <span class="fw-bold" style="color:{{ $k->skor_rata>=3.5?'#10B981':($k->skor_rata>=3?'#F59E0B':'#EF4444') }}">{{ $k->skor_rata }}/4.00</span>
                <div class="progress mt-1" style="height:5px;width:80px"><div class="progress-bar" style="width:{{ ($k->skor_rata/4)*100 }}%;background:#2563EB"></div></div>
            </td>
            @if(auth()->user()->canInput())
            <td>
                <button class="btn btn-sm btn-outline-primary py-0 px-2" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $k->id }}"><i class="bi bi-pencil"></i></button>
                <form action="{{ route('kepuasan.destroy', $k) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="button" class="btn btn-sm btn-outline-danger py-0 px-2 btn-hapus"><i class="bi bi-trash"></i></button></form>
            </td>
            @endif
        </tr>
        @empty
        <tr><td colspan="7" class="text-center py-4 text-muted">Belum ada data kepuasan tahun {{ $tahun }}.</td></tr>
        @endforelse
        </tbody>
    </table>
    </div>
</div></div>
@if(auth()->user()->canInput())
<div class="modal fade" id="modalTambah" tabindex="-1"><div class="modal-dialog"><div class="modal-content">
    <form action="{{ route('kepuasan.store') }}" method="POST">@csrf
        <div class="modal-header"><h6 class="modal-title fw-semibold">Tambah Data Kepuasan</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
        <div class="modal-body">
            <div class="mb-3"><label class="form-label fw-semibold" style="font-size:12px">Aspek *</label><input type="text" name="aspek" class="form-control form-control-sm" placeholder="Reliability, Responsiveness..." required></div>
            <div class="row g-2 mb-3">
                <div class="col-3"><label class="form-label" style="font-size:11px">Tidak Puas (%)</label><input type="number" step="0.01" name="tidak_puas" class="form-control form-control-sm" value="0"></div>
                <div class="col-3"><label class="form-label" style="font-size:11px">Kurang Puas (%)</label><input type="number" step="0.01" name="kurang_puas" class="form-control form-control-sm" value="0"></div>
                <div class="col-3"><label class="form-label" style="font-size:11px">Puas (%)</label><input type="number" step="0.01" name="puas" class="form-control form-control-sm" value="0"></div>
                <div class="col-3"><label class="form-label" style="font-size:11px">Sangat Puas (%)</label><input type="number" step="0.01" name="sangat_puas" class="form-control form-control-sm" value="0"></div>
            </div>
            <div><label class="form-label fw-semibold" style="font-size:12px">Tahun *</label><input type="number" name="tahun" class="form-control form-control-sm" value="{{ $tahun }}" required></div>
        </div>
        <div class="modal-footer"><button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button><button type="submit" class="btn btn-sm btn-primary">Simpan</button></div>
    </form>
</div></div></div>
@endif
@endsection
@push('scripts')
<script>
@if($kepuasan->isNotEmpty())
new Chart(document.getElementById('chartKepuasan'), {
    type: 'bar',
    data: {
        labels: @json($kepuasan->pluck('aspek')),
        datasets: [{
            label: 'Skor Rata-rata',
            data: @json($kepuasan->pluck('skor_rata')),
            backgroundColor: '#2563EB',
            borderRadius: 5,
            barPercentage: 0.6,
        }]
    },
    options: {
        responsive: true,
        scales: { y: { beginAtZero: true, max: 4, ticks: { callback: v => v + '/4' } } },
        plugins: { legend: { display: false } }
    }
});
@endif
</script>
@endpush
