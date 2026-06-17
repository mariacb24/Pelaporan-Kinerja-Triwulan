@extends('layouts.app')
@section('title', 'Laporan')
@section('page-title', 'Laporan Kinerja')
@section('content')
<div class="d-flex gap-3 flex-wrap mb-4">
    <a href="{{ route('laporan.draft', ['triwulan'=>request('triwulan',ceil(now()->month/3)),'tahun'=>request('tahun',now()->year)]) }}"
       class="card p-3 text-decoration-none flex-grow-1" style="border-left:4px solid #2563EB">
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-file-earmark-text" style="font-size:2rem;color:#2563EB"></i>
            <div><div class="fw-bold">Draft Laporan</div><small class="text-muted">Laporan belum final</small></div>
        </div>
    </a>
    <a href="{{ route('laporan.final', ['triwulan'=>request('triwulan',ceil(now()->month/3)),'tahun'=>request('tahun',now()->year)]) }}"
       class="card p-3 text-decoration-none flex-grow-1" style="border-left:4px solid #10B981">
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-file-earmark-check" style="font-size:2rem;color:#10B981"></i>
            <div><div class="fw-bold">Laporan Final</div><small class="text-muted">Laporan terverifikasi</small></div>
        </div>
    </a>
</div>
@endsection
