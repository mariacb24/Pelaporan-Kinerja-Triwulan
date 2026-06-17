<?php

namespace App\Exports;

use App\Models\IndikatorKinerja;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IndikatorExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    public function collection()
    {
        return IndikatorKinerja::with('kategori')->orderBy('kode_indikator')->get()
            ->map(fn($item, $i) => [
                'no'               => $i + 1,
                'kode'             => $item->kode_indikator,
                'nama'             => $item->nama_indikator,
                'kategori'         => $item->kategori->nama_kategori,
                'target'           => $item->target,
                'satuan'           => $item->satuan,
                'bobot'            => $item->bobot,
                'formula'          => $item->formula_penilaian ?? '-',
                'status'           => ucfirst($item->status),
            ]);
    }

    public function headings(): array
    {
        return ['No', 'Kode', 'Nama Indikator', 'Kategori', 'Target', 'Satuan', 'Bobot', 'Formula', 'Status'];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF1E293B']], 'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']]],
        ];
    }
}
