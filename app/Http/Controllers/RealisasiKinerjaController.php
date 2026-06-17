<?php

namespace App\Http\Controllers;

use App\Models\IndikatorKinerja;
use App\Models\RealisasiKinerja;
use App\Services\RealisasiService;
use Illuminate\Http\Request;

class RealisasiKinerjaController extends Controller
{
    public function __construct(private RealisasiService $service) {}

    public function index(Request $request)
    {
        $tahun    = (int) $request->get('tahun', now()->year);
        $triwulan = (int) $request->get('triwulan', (int) ceil(now()->month / 3));

        $realisasi = RealisasiKinerja::with(['indikator.kategori', 'createdBy'])
            ->where('tahun', $tahun)
            ->where('triwulan', $triwulan)
            ->orderBy('indikator_id')
            ->paginate(20)->withQueryString();

        return view('realisasi.index', compact('realisasi', 'tahun', 'triwulan'));
    }

    public function create(Request $request)
    {
        $tahun    = (int) $request->get('tahun', now()->year);
        $triwulan = (int) $request->get('triwulan', (int) ceil(now()->month / 3));

        $indikator = IndikatorKinerja::aktif()->with('kategori')
            ->orderBy('kode_indikator')->get();

        $existing = RealisasiKinerja::where('tahun', $tahun)
            ->where('triwulan', $triwulan)
            ->pluck('realisasi', 'indikator_id');

        return view('realisasi.create', compact('indikator', 'tahun', 'triwulan', 'existing'));
    }

    public function store(Request $request)
    {
        $triwulan = (int) $request->input('triwulan');
        $tahun    = (int) $request->input('tahun');
        $action   = $request->input('action', 'submit');
        $items    = $request->input('items', []);

        $items = array_filter($items, fn($item) => isset($item['realisasi']) && $item['realisasi'] !== '');

        if (empty($items)) {
            return redirect()->back()
                ->with('error', 'Tidak ada data realisasi yang diinput.');
        }

        $status = $action === 'draft' ? 'draft' : 'menunggu';
        $saved  = 0;

        foreach ($items as $indikatorId => $item) {
            $indikator = IndikatorKinerja::find($indikatorId);
            if (!$indikator) continue;

            $realisasi  = (float) $item['realisasi'];
            $persentase = $indikator->target > 0
                ? round(($realisasi / $indikator->target) * 100, 2) : 0;
            $nilai = round($persentase * $indikator->bobot, 4);

            RealisasiKinerja::updateOrCreate(
                [
                    'indikator_id' => $indikatorId,
                    'triwulan'     => $triwulan,
                    'tahun'        => $tahun,
                ],
                [
                    'target'            => $indikator->target,
                    'realisasi'         => $realisasi,
                    'persentase'        => $persentase,
                    'nilai'             => $nilai,
                    'bobot_snapshot'    => $indikator->bobot,
                    'keterangan'        => $item['keterangan'] ?? null,
                    'status_verifikasi' => $status,
                    'created_by'        => auth()->id(),
                ]
            );
            $saved++;
        }

        $pesan = $action === 'draft'
            ? "{$saved} data berhasil disimpan sebagai draft."
            : "{$saved} data berhasil dikirim untuk verifikasi.";

        return redirect()->route('realisasi.index', ['tahun' => $tahun, 'triwulan' => $triwulan])
            ->with('success', $pesan);
    }

    public function edit(RealisasiKinerja $realisasi)
    {
        $realisasi->load('indikator.kategori');
        return view('realisasi.edit', compact('realisasi'));
    }

    public function update(Request $request, RealisasiKinerja $realisasi)
    {
        $validated = $request->validate([
            'realisasi'  => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:1000',
        ]);

        $indikator  = $realisasi->indikator;
        $persentase = $indikator->target > 0
            ? round(($validated['realisasi'] / $indikator->target) * 100, 2) : 0;

        $realisasi->update([
            'realisasi'         => $validated['realisasi'],
            'persentase'        => $persentase,
            'nilai'             => round($persentase * $realisasi->bobot_snapshot, 4),
            'keterangan'        => $validated['keterangan'],
            'status_verifikasi' => 'menunggu',
        ]);

        return redirect()->route('realisasi.index')
            ->with('success', 'Data realisasi berhasil diperbarui.');
    }

    public function destroy(RealisasiKinerja $realisasi)
    {
        if ($realisasi->status_verifikasi === 'terverifikasi') {
            return back()->with('error', 'Data yang sudah terverifikasi tidak dapat dihapus.');
        }
        $realisasi->delete();
        return back()->with('success', 'Data realisasi berhasil dihapus.');
    }

    public function verifikasi(Request $request, RealisasiKinerja $realisasi)
    {
        $request->validate(['status' => 'required|in:terverifikasi,ditolak']);

        $realisasi->update([
            'status_verifikasi' => $request->status,
            'verified_by'       => auth()->id(),
            'verified_at'       => now(),
        ]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Status verifikasi berhasil diperbarui.');
    }
}
