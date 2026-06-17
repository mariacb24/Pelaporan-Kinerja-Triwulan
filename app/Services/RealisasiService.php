<?php

namespace App\Services;

use App\Models\IndikatorKinerja;
use App\Models\RealisasiKinerja;
use Illuminate\Support\Facades\DB;

class RealisasiService
{
    /**
     * Memproses penyimpanan data realisasi secara massal (Bulk/Batch)
     */
    public function simpanRealisasi(array $data, int $userId): void
    {
        $triwulan = $data['triwulan'];
        $tahun = $data['tahun'];
        $items = $data['items'] ?? [];
        
        // Tentukan status berdasarkan tombol yang diklik (draft atau submit)
        $statusVerifikasi = ($data['action'] === 'submit') ? 'menunggu' : 'draft';

        DB::transaction(function () use ($items, $triwulan, $tahun, $statusVerifikasi, $userId) {
            foreach ($items as $indikatorId => $item) {
                // Lewati jika input nilai realisasi kosong / tidak diisi
                if ($item['realisasi'] === null || $item['realisasi'] === '') {
                    continue;
                }

                $indikator = IndikatorKinerja::findOrFail($indikatorId);
                $realisasiNilai = floatval($item['realisasi']);

                // Hitung persentase capaian
                $persentase = $indikator->target > 0
                    ? round(($realisasiNilai / $indikator->target) * 100, 2)
                    : 0;

                // Hitung nilai akhir berdasarkan bobot snapshot
                $nilai = round(($persentase / 100) * $indikator->bobot, 4);

                // Simpan draft atau perbarui data realisasi
                RealisasiKinerja::updateOrCreate(
                    [
                        'indikator_id' => $indikatorId,
                        'triwulan'     => $triwulan,
                        'tahun'        => $tahun,
                    ],
                    [
                        'target'             => $indikator->target,
                        'realisasi'          => $realisasiNilai,
                        'persentase'         => $persentase,
                        'nilai'              => $nilai,
                        'bobot_snapshot'     => $indikator->bobot,
                        'keterangan'         => $item['keterangan'] ?? null,
                        'status_verifikasi'  => $statusVerifikasi,
                        'created_by'         => $userId,
                    ]
                );
            }
        });
    }

    /**
     * Verifikasi data tunggal oleh Admin
     */
    public function verifikasi(RealisasiKinerja $realisasi, string $status, int $userId): void
    {
        $realisasi->update([
            'status_verifikasi' => $status,
            'verified_by'       => $userId,
            'verified_at'       => now(),
        ]);
    }
}