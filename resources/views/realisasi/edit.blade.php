@extends('layouts.app')
@section('title', 'Edit Realisasi')
@section('page-title', 'Edit Realisasi Kinerja')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Edit Realisasi</h5>
    <a href="{{ route('realisasi.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card" style="max-width:600px">
    <div class="card-body">
        <div class="mb-3 p-3 rounded" style="background:#F8FAFC">
            <div class="row g-2" style="font-size:13px">
                <div class="col-6"><span class="text-muted">Kode:</span> <strong>{{ $realisasi->indikator->kode_indikator }}</strong></div>
                <div class="col-6"><span class="text-muted">Periode:</span> <strong>TW{{ $realisasi->triwulan }} / {{ $realisasi->tahun }}</strong></div>
                <div class="col-12"><span class="text-muted">Indikator:</span> <strong>{{ $realisasi->indikator->nama_indikator }}</strong></div>
                <div class="col-6"><span class="text-muted">Target:</span> <strong>{{ number_format($realisasi->target,2) }} {{ $realisasi->indikator->satuan }}</strong></div>
            </div>
        </div>
        <form action="{{ route('realisasi.update', $realisasi) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:13px">Realisasi *</label>
                <div class="input-group">
                    <input type="number" name="realisasi" step="0.01" min="0"
                           class="form-control" id="realisasiInput"
                           value="{{ old('realisasi', $realisasi->realisasi) }}" required>
                    <span class="input-group-text">{{ $realisasi->indikator->satuan }}</span>
                </div>
            </div>
            <div class="mb-3 p-2 rounded" style="background:#EFF6FF">
                <span style="font-size:12px;color:#64748B">Persentase: </span>
                <span id="pctPreview" class="fw-bold" style="color:#2563EB">{{ $realisasi->persentase }}%</span>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold" style="font-size:13px">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $realisasi->keterangan) }}</textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('realisasi.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
const target = {{ $realisasi->target }};
document.getElementById('realisasiInput').addEventListener('input', function() {
    const pct = target > 0 ? ((parseFloat(this.value)||0)/target*100).toFixed(2) : 0;
    const el = document.getElementById('pctPreview');
    el.textContent = pct + '%';
    el.style.color = pct>=100?'#10B981':pct>=75?'#F59E0B':'#EF4444';
});
</script>
@endpush
