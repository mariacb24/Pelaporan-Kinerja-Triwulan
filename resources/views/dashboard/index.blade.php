@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Kinerja BPM')

@section('content')
<div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
    <div>
        <h5 class="fw-bold mb-1">Ringkasan Kinerja BPM</h5>
        <p class="text-muted mb-0" style="font-size:12px">
            <i class="bi bi-calendar3 me-1"></i>Triwulan {{ $triwulan }} &middot; Tahun {{ $tahun }}
        </p>
    </div>
    <form class="d-flex gap-2 align-items-center flex-wrap">
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

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="border-left-color:#2563EB">
            <div class="card-body py-3">
                <div class="text-muted mb-1" style="font-size:11px;font-weight:600">TOTAL INDIKATOR</div>
                <div class="fs-2 fw-bold text-primary">{{ $stats['total_indikator'] }}</div>
                <small class="text-muted">Indikator aktif</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="border-left-color:#10B981">
            <div class="card-body py-3">
                <div class="text-muted mb-1" style="font-size:11px;font-weight:600">DOKUMEN ONLINE</div>
                <div class="fs-2 fw-bold" style="color:#10B981">{{ $stats['total_dokumen'] }}</div>
                <small class="text-muted">Tersedia di website</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="border-left-color:#F59E0B">
            <div class="card-body py-3">
                <div class="text-muted mb-1" style="font-size:11px;font-weight:600">AKREDITASI</div>
                <div class="fs-2 fw-bold" style="color:#F59E0B">{{ $stats['total_akreditasi'] }}</div>
                <small class="text-muted">Program studi</small>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card h-100" style="border-left-color:#8B5CF6">
            <div class="card-body py-3">
                <div class="text-muted mb-1" style="font-size:11px;font-weight:600">SURVEI AKTIF</div>
                <div class="fs-2 fw-bold" style="color:#8B5CF6">{{ $stats['total_survei'] }}</div>
                <small class="text-muted">Tahun {{ $tahun }}</small>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-header-bpm">Capaian Kinerja Per Triwulan {{ $tahun }}</div>
                <canvas id="chartTriwulan" style="max-height:260px"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
                <div class="card-header-bpm w-100 text-start">Capaian TW{{ $triwulan }}</div>
                <div style="position:relative;width:160px;height:160px;margin:8px auto">
                    <canvas id="chartDonut"></canvas>
                    <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%)">
                        <div class="fw-bold text-primary" style="font-size:22px">{{ $persentaseCapaian }}%</div>
                        <div style="font-size:10px;color:#94A3B8">rata-rata</div>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-2 flex-wrap justify-content-center">
                    <span class="badge" style="background:#D1FAE5;color:#065F46;font-size:11px">
                        <i class="bi bi-check-circle me-1"></i>{{ $indikatorTercapai }} Tercapai
                    </span>
                    <span class="badge" style="background:#FEE2E2;color:#991B1B;font-size:11px">
                        <i class="bi bi-x-circle me-1"></i>{{ $indikatorBelum }} Belum
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Kepuasan & Terbaru -->
<div class="row g-3">
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-header-bpm">Kepuasan Mahasiswa {{ $tahun }}</div>
                @forelse($kepuasan as $item)
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span style="font-size:12px">{{ $item->aspek }}</span>
                        <span class="fw-semibold" style="font-size:12px;color:#2563EB">{{ $item->skor_rata }}/4.00</span>
                    </div>
                    <div class="progress" style="height:7px;border-radius:4px">
                        <div class="progress-bar" style="width:{{ ($item->skor_rata/4)*100 }}%;background:#2563EB;border-radius:4px"></div>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center" style="font-size:13px">Belum ada data kepuasan.</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-header-bpm">Realisasi Terbaru</div>
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead>
                            <tr>
                                <th>Indikator</th>
                                <th>Realisasi</th>
                                <th>%</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($realisasiTerbaru as $r)
                            <tr>
                                <td>
                                    <span style="font-size:11px;color:#94A3B8">{{ $r->indikator->kode_indikator }}</span><br>
                                    <span style="font-size:12px">{{ Str::limit($r->indikator->nama_indikator, 30) }}</span>
                                </td>
                                <td style="font-size:12px">{{ number_format($r->realisasi, 2) }} {{ $r->indikator->satuan }}</td>
                                <td>
                                    @php $pct = $r->persentase; @endphp
                                    <span class="{{ $pct>=100 ? 'pct-high' : ($pct>=75 ? 'pct-mid' : 'pct-low') }}" style="font-size:12px">
                                        {{ $pct }}%
                                    </span>
                                </td>
                                <td>{!! $r->status_badge !!}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted" style="font-size:13px">Belum ada data.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    <a href="{{ route('realisasi.index', ['tahun'=>$tahun,'triwulan'=>$triwulan]) }}"
                       class="btn btn-sm btn-outline-primary w-100" style="font-size:12px">
                        Lihat Semua Realisasi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('chartTriwulan'), {
    type: 'bar',
    data: {
        labels: ['Triwulan 1', 'Triwulan 2', 'Triwulan 3', 'Triwulan 4'],
        datasets: [
            {
                label: 'Capaian (%)',
                data: @json($chartTriwulan),
                backgroundColor: '#2563EB',
                borderRadius: 6,
                barPercentage: 0.6,
            },
            {
                label: 'Target (100%)',
                type: 'line',
                data: [100, 100, 100, 100],
                borderColor: '#EF4444',
                borderDash: [5, 5],
                pointRadius: 0,
                fill: false,
                borderWidth: 1.5,
            }
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { labels: { font: { size: 11 }, boxWidth: 12 } } },
        scales: {
            y: {
                beginAtZero: true, max: 130,
                ticks: { callback: v => v + '%', font: { size: 11 } }
            },
            x: { ticks: { font: { size: 11 } } }
        }
    }
});

new Chart(document.getElementById('chartDonut'), {
    type: 'doughnut',
    data: {
        labels: ['Tercapai', 'Belum'],
        datasets: [{ data: [{{ $indikatorTercapai }}, {{ $indikatorBelum }}], backgroundColor: ['#10B981', '#EF4444'], borderWidth: 0 }]
    },
    options: {
        cutout: '70%',
        plugins: { legend: { display: false } }
    }
});
</script>
@endpush
