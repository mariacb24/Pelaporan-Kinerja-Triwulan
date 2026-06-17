@extends('layouts.app')
@section('title', 'Detail Indikator')
@section('page-title', 'Detail Indikator')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h5 class="fw-bold">{{ $indikator->kode_indikator }} - {{ $indikator->nama_indikator }}</h5>
    <a href="{{ route('indikator.index') }}" class="btn btn-outline-secondary btn-sm">Kembali</a>
</div>
<div class="card">
    <div class="card-body">
        <dl class="row">
            <dt class="col-3">Kategori</dt><dd class="col-9">{{ $indikator->kategori->nama_kategori }}</dd>
            <dt class="col-3">Target</dt><dd class="col-9">{{ $indikator->target }} {{ $indikator->satuan }}</dd>
            <dt class="col-3">Bobot</dt><dd class="col-9">{{ $indikator->bobot }}</dd>
            <dt class="col-3">Formula</dt><dd class="col-9">{{ $indikator->formula_penilaian ?? '-' }}</dd>
            <dt class="col-3">Status</dt><dd class="col-9">{{ ucfirst($indikator->status) }}</dd>
        </dl>
    </div>
</div>
@endsection
