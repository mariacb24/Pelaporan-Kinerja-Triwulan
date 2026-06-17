<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class IndikatorKinerja extends Model
{
    use HasFactory;

    protected $table = 'indikator_kinerja';

    protected $fillable = [
        'kode_indikator', 'nama_indikator', 'kategori_id',
        'target', 'satuan', 'bobot', 'formula_penilaian', 'status',
    ];

    protected $casts = [
        'target' => 'decimal:2',
        'bobot'  => 'decimal:2',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriIndikator::class, 'kategori_id');
    }

    public function realisasi()
    {
        return $this->hasMany(RealisasiKinerja::class, 'indikator_id');
    }

    public function realisasiTerbaru()
    {
        return $this->hasOne(RealisasiKinerja::class, 'indikator_id')->latest();
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}
