<?php

namespace App\Services;

use App\Models\RealisasiKinerja;
use App\Models\KepuasanMahasiswa;
use App\Models\Akreditasi;
use App\Models\DokumenWebsite;

class LaporanService
{
    public function getLaporan(int $tahun, int $triwulan, bool $isFinal = false): array
    {
        $query = RealisasiKinerja::with(['indikator.kategori', 'createdBy', 'verifiedBy'])
            ->where('tahun', $tahun)
            ->where('triwulan', $triwulan);

        if ($isFinal) {
            $query->where('status_verifikasi', 'terverifikasi');
        } else {
            $query->whereIn('status_verifikasi', ['draft', 'menunggu', 'terverifikasi']);
        }

        $realisasi = $query->orderBy('indikator_id')->get();

        $totalIndikator   = $realisasi->count();
        $tercapai         = $realisasi->filter(fn($r) => $r->persentase >= 100)->count();
        $belumTercapai    = $totalIndikator - $tercapai;
        $rataCapaian      = $realisasi->isNotEmpty() ? round($realisasi->avg('persentase'), 2) : 0;
        $totalNilai       = round($realisasi->sum('nilai'), 2);
        $byKategori       = $realisasi->groupBy(fn($r) => $r->indikator->kategori->nama_kategori ?? 'Lainnya');

        $kepuasan         = KepuasanMahasiswa::where('tahun', $tahun)->get();
        $skorKepuasan     = $kepuasan->isNotEmpty() ? round($kepuasan->avg('skor_rata'), 2) : 0;
        $totalDokumen     = DokumenWebsite::where('status', 'tersedia')->count();
        $totalAkreditasi  = Akreditasi::count();

        return compact(
            'realisasi', 'totalIndikator', 'tercapai', 'belumTercapai',
            'rataCapaian', 'totalNilai', 'byKategori',
            'kepuasan', 'skorKepuasan', 'totalDokumen', 'totalAkreditasi'
        );
    }

    public function getChartData(int $tahun): array
    {
        $data = [];
        for ($tw = 1; $tw <= 4; $tw++) {
            $avg = RealisasiKinerja::where('tahun', $tahun)->where('triwulan', $tw)->avg('persentase');
            $data[] = round($avg ?? 0, 2);
        }
        return $data;
    }
}
