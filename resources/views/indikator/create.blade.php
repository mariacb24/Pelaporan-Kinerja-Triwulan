@extends('layouts.app')
@section('title', 'Tambah Indikator')
@section('page-title', 'Tambah Indikator Kinerja')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold mb-0">Tambah Indikator</h5>
    <a href="{{ route('indikator.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Kembali</a>
</div>
<div class="card" style="max-width:700px">
    <div class="card-body">
        <form action="{{ route('indikator.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold" style="font-size:12px">Kode Indikator *</label>
                    <input type="text" name="kode_indikator" class="form-control @error('kode_indikator') is-invalid @enderror" value="{{ old('kode_indikator') }}" placeholder="IK-AK-01" required>
                    @error('kode_indikator')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold" style="font-size:12px">Nama Indikator *</label>
                    <input type="text" name="nama_indikator" class="form-control @error('nama_indikator') is-invalid @enderror" value="{{ old('nama_indikator') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold" style="font-size:12px">Kategori *</label>
                    <select name="kategori_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $kat)
                        <option value="{{ $kat->id }}" {{ old('kategori_id')==$kat->id?'selected':'' }}>{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="font-size:12px">Target *</label>
                    <input type="number" name="target" step="0.01" class="form-control" value="{{ old('target') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="font-size:12px">Satuan *</label>
                    <input type="text" name="satuan" class="form-control" value="{{ old('satuan') }}" placeholder="%, Orang..." required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="font-size:12px">Bobot *</label>
                    <input type="number" name="bobot" step="0.01" class="form-control" value="{{ old('bobot', 1.00) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold" style="font-size:12px">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold" style="font-size:12px">Formula Penilaian</label>
                    <textarea name="formula_penilaian" class="form-control" rows="2" placeholder="Contoh: (Realisasi / Target) x 100">{{ old('formula_penilaian') }}</textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('indikator.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
