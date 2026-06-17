@extends('layouts.app')
@section('title', 'Draft Laporan')
@section('page-title', 'Draft Laporan Kinerja')
@section('content')
<div class="d-flex justify-content-between align-items-start mb-3 flex-wrap gap-2">
    <div>
        <h5 class="fw-bold mb-0">Draft Laporan Kinerja BPM</h5>
        <p class="text-muted mb-0" style="font-size:12px">Triwulan {{ $triwulan }} &middot; Tahun {{ $tahun }}</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <form method="GET" class="d-flex gap-2">
            <select name="triwulan" class="form-select form-select-sm" style="width:auto">
                @for($i=1;$i<=4;$i++)<option value="{{ $i }}" {{ $i==$triwulan?"selected":"" }}>TW{{ $i }}</option>@endfor
            </select>
            <select name="tahun" class="form-select form-select-sm" style="width:auto">
                @for($y=2023;$y<=now()->year+1;$y++)<option value="{{ $y }}" {{ $y==$tahun?"selected":"" }}>{{ $y }}</option>@endfor
            </select>
            <button class="btn btn-sm btn-primary">Terapkan</button>
        </form>
        <a href="{{ route('laporan.pdf', ['triwulan'=>$triwulan,'tahun'=>$tahun]) }}" class="btn btn-sm btn-outline-danger"><i class="bi bi-file-earmark-pdf me-1"></i>PDF</a>
        <a href="{{ route('laporan.excel', ['triwulan'=>$triwulan,'tahun'=>$tahun]) }}" class="btn btn-sm btn-outline-success"><i class="bi bi-file-earmark-excel me-1"></i>Excel</a>
    </div>
</div>
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3"><div class="card text-center" style="border-top:3px solid #2563EB"><div class="card-body py-2"><div class="fs-3 fw-bold text-primary">{{ $laporan['totalIndikator'] }}</div><div style="font-size:11px;color:#94A3B8">Total Indikator</div></div></div></div>
    <div class="col-6 col-md-3"><div class="card text-center" style="border-top:3px solid #10B981"><div class="card-body py-2"><div class="fs-3 fw-bold" style="color:#10B981">{{ $laporan['tercapai'] }}</div><div style="font-size:11px;color:#94A3B8">Tercapai</div></div></div></div>
    <div class="col-6 col-md-3"><div class="card text-center" style="border-top:3px solid #EF4444"><div class="card-body py-2"><div class="fs-3 fw-bold" style="color:#EF4444">{{ $laporan['belumTercapai'] }}</div><div style="font-size:11px;color:#94A3B8">Belum Tercapai</div></div></div></div>
    <div class="col-6 col-md-3"><div class="card text-center" style="border-top:3px solid #F59E0B"><div class="card-body py-2"><div class="fs-3 fw-bold" style="color:#F59E0B">{{ $laporan['rataCapaian'] }}%</div><div style="font-size:11px;color:#94A3B8">Rata-rata</div></div></div></div>
</div>
@foreach($laporan['byKategori'] as $kategori => $items)
<div class="card mb-3">
    <div class="card-header" style="background:#F8FAFC"><span class="fw-semibold" style="font-size:13px">{{ $kategori }}</span></div>
    <div class="card-body p-0">
        <div class="table-responsive">
        <table class="table table-sm mb-0" style="font-size:13px">
            <thead><tr><th class="ps-3">Kode</th><th>Nama Indikator</th><th>Target</th><th>Realisasi</th><th>%</th><th>Nilai</th><th>Status</th></tr></thead>
            <tbody>
            @foreach($items as $r)
            <tr>
                <td class="ps-3"><span class="badge" style="background:#EFF6FF;color:#1D4ED8;font-size:10px">{{ $r->indikator->kode_indikator }}</span></td>
                <td>{{ $r->indikator->nama_indikator }}</td>
                <td>{{ number_format($r->target,2) }} {{ $r->indikator->satuan }}</td>
                <td class="fw-semibold">{{ number_format($r->realisasi,2) }}</td>
                <td>@php $p=$r->persentase; @endphp<span class="{{ $p>=100 ? 'pct-high' : ($p>=75 ? 'pct-mid' : 'pct-low') }}">{{ $p }}%</span></td>
                <td>{{ number_format($r->nilai,2) }}</td>
                <td><span class="badge badge-{{ $r->status_verifikasi }}" style="font-size:10px">{{ ucfirst(str_replace('_',' ',$r->status_verifikasi)) }}</span></td>
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>
@endforeach
@if($laporan['realisasi']->isEmpty())
<div class="card"><div class="card-body text-center py-5"><i class="bi bi-inbox" style="font-size:3rem;color:#CBD5E1"></i><p class="text-muted mt-3">Belum ada data realisasi untuk periode ini.</p></div></div>
@endif
@endsection
