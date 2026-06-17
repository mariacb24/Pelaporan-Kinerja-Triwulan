<?php

namespace App\Http\Controllers;

use App\Models\IndikatorKinerja;
use App\Models\RealisasiKinerja;
use App\Models\DokumenWebsite;
use App\Models\Akreditasi;
use App\Models\Survei;
use App\Models\KepuasanMahasiswa;
use App\Services\LaporanService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(private LaporanService $laporanService) {}

    public function index(Request $request)
    {
        $tahun    = (int) $request->get('tahun', now()->year);
        $triwulan = (int) $request->get('triwulan', (int) ceil(now()->month / 3));

        $stats = [
            'total_indikator' => IndikatorKinerja::where('status', 'aktif')->count(),
            'total_dokumen'   => DokumenWebsite::where('status', 'tersedia')->count(),
            'total_akreditasi'=> Akreditasi::count(),
            'total_survei'    => Survei::where('tahun', $tahun)->count(),
        ];

        $realisasiData = RealisasiKinerja::with('indikator')
            ->where('tahun', $tahun)
            ->where('triwulan', $triwulan)
            ->get();

        $persentaseCapaian   = $realisasiData->isNotEmpty() ? round($realisasiData->avg('persentase'), 1) : 0;
        $indikatorTercapai   = $realisasiData->where('persentase', '>=', 100)->count();
        $indikatorBelum      = $realisasiData->where('persentase', '<', 100)->count();

        $chartTriwulan = $this->laporanService->getChartData($tahun);

        $kepuasan = KepuasanMahasiswa::where('tahun', $tahun)->get();

        $realisasiTerbaru = RealisasiKinerja::with(['indikator.kategori'])
            ->where('tahun', $tahun)->where('triwulan', $triwulan)
            ->orderByDesc('updated_at')->take(5)->get();

        return view('dashboard.index', compact(
            'stats', 'persentaseCapaian', 'indikatorTercapai', 'indikatorBelum',
            'chartTriwulan', 'kepuasan', 'tahun', 'triwulan', 'realisasiTerbaru'
        ));
    }

    public function chartData(Request $request)
    {
        $tahun = (int) $request->get('tahun', now()->year);
        return response()->json($this->laporanService->getChartData($tahun));
    }
}
