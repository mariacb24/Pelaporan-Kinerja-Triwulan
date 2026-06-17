<?php

namespace App\Http\Controllers;

use App\Services\LaporanService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function __construct(private LaporanService $service) {}

    public function index(Request $request)
    {
        $tahun    = (int) $request->get('tahun', now()->year);
        $triwulan = (int) $request->get('triwulan', (int) ceil(now()->month / 3));
        $laporan  = $this->service->getLaporan($tahun, $triwulan);

        return view('laporan.index', compact('laporan', 'tahun', 'triwulan'));
    }

    public function draft(Request $request)
    {
        $tahun    = (int) $request->get('tahun', now()->year);
        $triwulan = (int) $request->get('triwulan', (int) ceil(now()->month / 3));
        $laporan  = $this->service->getLaporan($tahun, $triwulan);

        return view('laporan.draft', compact('laporan', 'tahun', 'triwulan'));
    }

    public function final(Request $request)
    {
        $tahun    = (int) $request->get('tahun', now()->year);
        $triwulan = (int) $request->get('triwulan', (int) ceil(now()->month / 3));
        $laporan  = $this->service->getLaporan($tahun, $triwulan, true);

        return view('laporan.final', compact('laporan', 'tahun', 'triwulan'));
    }

    public function generatePdf(Request $request)
    {
        $tahun    = (int) $request->get('tahun', now()->year);
        $triwulan = (int) $request->get('triwulan', (int) ceil(now()->month / 3));
        $laporan  = $this->service->getLaporan($tahun, $triwulan, true);

        $pdf = Pdf::loadView('laporan.pdf', compact('laporan', 'tahun', 'triwulan'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("laporan_kinerja_bpm_tw{$triwulan}_{$tahun}.pdf");
    }

    public function generateExcel(Request $request)
    {
        $tahun    = (int) $request->get('tahun', now()->year);
        $triwulan = (int) $request->get('triwulan', (int) ceil(now()->month / 3));

        return Excel::download(
            new \App\Exports\LaporanExport($tahun, $triwulan),
            "laporan_kinerja_bpm_tw{$triwulan}_{$tahun}.xlsx"
        );
    }
}
