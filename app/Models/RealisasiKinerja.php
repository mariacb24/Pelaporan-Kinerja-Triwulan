<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RealisasiKinerja extends Model
{
    protected $table = 'realisasi_kinerja';

    protected $fillable = [
        'indikator_id', 'triwulan', 'tahun', 'target', 'realisasi',
        'persentase', 'nilai', 'bobot_snapshot', 'keterangan',
        'status_verifikasi', 'created_by', 'verified_by', 'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'persentase'  => 'decimal:2',
        'nilai'       => 'decimal:4',
    ];

    public function indikator()
    {
        return $this->belongsTo(IndikatorKinerja::class, 'indikator_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function hitungPersentase(): float
    {
        if ($this->target <= 0) return 0;
        return round(($this->realisasi / $this->target) * 100, 2);
    }

    public function hitungNilai(): float
    {
        return round($this->hitungPersentase() * $this->bobot_snapshot, 4);
    }

    public function getTriwulanLabelAttribute(): string
    {
        return 'Triwulan ' . $this->triwulan;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status_verifikasi) {
            'draft'        => '<span class="badge bg-secondary">Draft</span>',
            'menunggu'     => '<span class="badge bg-warning text-dark">Menunggu</span>',
            'terverifikasi'=> '<span class="badge bg-success">Terverifikasi</span>',
            'ditolak'      => '<span class="badge bg-danger">Ditolak</span>',
            default        => '<span class="badge bg-light text-muted">-</span>',
        };
    }

    public function scopeByPeriode($query, int $triwulan, int $tahun)
    {
        return $query->where('triwulan', $triwulan)->where('tahun', $tahun);
    }
}
