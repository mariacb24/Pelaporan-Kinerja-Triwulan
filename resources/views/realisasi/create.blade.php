@extends('layouts.app')
@section('title', 'Input Realisasi')
@section('page-title', 'Input Realisasi Kinerja')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div>
        <h5 class="fw-bold mb-0">Input Realisasi Kinerja</h5>
        <p class="text-muted mb-0" style="font-size:12px">Triwulan {{ $triwulan }} &middot; Tahun {{ $tahun }}</p>
    </div>
</div>

<div class="alert alert-info py-2 mb-3" style="font-size:13px">
    <i class="bi bi-info-circle-fill me-2"></i>
    Input realisasi per indikator untuk periode Triwulan {{ $triwulan }} Tahun {{ $tahun }}.
    Setelah disimpan, data akan dikirim untuk verifikasi.
</div>

<!-- Filter Periode -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="d-flex gap-2 align-items-center flex-wrap">
            <label style="font-size:12px;font-weight:600;margin-bottom:0">Periode:</label>
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
            <button type="submit" class="btn btn-sm btn-primary">Terapkan</button>
        </form>
    </div>
</div>

<!-- Input Form -->
<div class="card">
    <div class="card-body p-0">
        <form action="{{ route('realisasi.store') }}" method="POST" id="formBulk">
            @csrf
            <input type="hidden" name="triwulan" value="{{ $triwulan }}">
            <input type="hidden" name="tahun" value="{{ $tahun }}">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3" style="width:110px">Kode</th>
                            <th>Nama Indikator</th>
                            <th>Kategori</th>
                            <th style="width:100px">Target</th>
                            <th>Satuan</th>
                            <th style="width:130px">Realisasi *</th>
                            <th style="width:80px">%</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($indikator as $item)
                        <tr>
                            <td class="ps-3">
                                <span class="badge" style="background:#EFF6FF;color:#1D4ED8;font-size:10px">{{ $item->kode_indikator }}</span>
                            </td>
                            <td style="font-size:13px">{{ $item->nama_indikator }}</td>
                            <td style="font-size:12px;color:#64748B">{{ $item->kategori->nama_kategori }}</td>
                            <td style="font-size:13px;font-weight:600">{{ number_format($item->target, 2) }}</td>
                            <td style="font-size:12px">{{ $item->satuan }}</td>
                            <td>
                                <input type="number"
                                       name="items[{{ $item->id }}][realisasi]"
                                       step="0.01" min="0"
                                       class="form-control form-control-sm realisasi-input"
                                       data-target="{{ $item->target }}"
                                       data-row="{{ $item->id }}"
                                       value="{{ $existing[$item->id] ?? '' }}"
                                       placeholder="0">
                                <input type="hidden" name="items[{{ $item->id }}][indikator_id]" value="{{ $item->id }}">
                            </td>
                            <td>
                                <span class="pct-display fw-semibold" id="pct-{{ $item->id }}" style="font-size:13px">
                                    @if(isset($existing[$item->id]) && $item->target > 0)
                                        {{ number_format(($existing[$item->id] / $item->target) * 100, 1) }}%
                                    @else
                                        —
                                    @endif
                                </span>
                            </td>
                            <td>
                                <input type="text" name="items[{{ $item->id }}][keterangan]"
                                       class="form-control form-control-sm"
                                       placeholder="Opsional..." style="font-size:12px">
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="text-center py-4 text-muted">Tidak ada indikator aktif.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3 d-flex justify-content-between align-items-center border-top">
                <small class="text-muted">* Isi hanya indikator yang memiliki realisasi periode ini</small>
                <div class="d-flex gap-2">
                    <button type="submit" name="action" value="draft" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-floppy me-1"></i>Simpan Draft
                    </button>
                    <button type="submit" name="action" value="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-send me-1"></i>Kirim untuk Verifikasi
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Hitung persentase otomatis
document.querySelectorAll('.realisasi-input').forEach(input => {
    input.addEventListener('input', function() {
        const target = parseFloat(this.dataset.target) || 0;
        const realisasi = parseFloat(this.value) || 0;
        const pctEl = document.getElementById('pct-' + this.dataset.row);
        if (target > 0 && realisasi > 0) {
            const pct = (realisasi / target * 100).toFixed(1);
            pctEl.textContent = pct + '%';
            pctEl.className = 'pct-display fw-semibold';
            if (pct >= 100) pctEl.style.color = '#10B981';
            else if (pct >= 75) pctEl.style.color = '#F59E0B';
            else pctEl.style.color = '#EF4444';
        } else {
            pctEl.textContent = '—';
            pctEl.style.color = '';
        }
    });
});
</script>
@endpush
