<?php

namespace App\Exports;

use App\Models\RealisasiKinerja;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
{
    public function __construct(
        private int $tahun,
        private int $triwulan
    ) {}

    public function collection()
    {
        return RealisasiKinerja::with(['indikator.kategori'])
            ->where('tahun', $this->tahun)
            ->where('triwulan', $this->triwulan)
            ->orderBy('indikator_id')
            ->get()
            ->map(fn($r, $i) => [
                'no'             => $i + 1,
                'kode'           => $r->indikator->kode_indikator,
                'nama_indikator' => $r->indikator->nama_indikator,
                'kategori'       => $r->indikator->kategori->nama_kategori,
                'target'         => $r->target,
                'satuan'         => $r->indikator->satuan,
                'realisasi'      => $r->realisasi,
                'persentase'     => $r->persentase . '%',
                'bobot'          => $r->bobot_snapshot,
                'nilai'          => $r->nilai,
                'status'         => ucfirst(str_replace('_', ' ', $r->status_verifikasi)),
                'keterangan'     => $r->keterangan ?? '-',
            ]);
    }

    public function headings(): array
    {
        return [
            'No', 'Kode', 'Nama Indikator', 'Kategori',
            'Target', 'Satuan', 'Realisasi', 'Persentase',
            'Bobot', 'Nilai', 'Status', 'Keterangan',
        ];
    }

    public function title(): string
    {
        return "Laporan TW{$this->triwulan} {$this->tahun}";
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF2563EB']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}
