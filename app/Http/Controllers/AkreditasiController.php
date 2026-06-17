<?php

namespace App\Http\Controllers;

use App\Models\Akreditasi;
use Illuminate\Http\Request;

class AkreditasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Akreditasi::query();
        if ($request->filled('jenjang')) $query->where('jenjang', $request->jenjang);
        if ($request->filled('search'))  $query->where('program_studi', 'like', '%'.$request->search.'%');
        $akreditasi = $query->orderBy('program_studi')->paginate(15)->withQueryString();
        $stats = [
            'unggul'     => Akreditasi::where('status_akreditasi', 'Unggul')->count(),
            'baik_sekali'=> Akreditasi::where('status_akreditasi', 'Baik Sekali')->count(),
            'baik'       => Akreditasi::where('status_akreditasi', 'Baik')->count(),
            'total'      => Akreditasi::count(),
        ];
        return view('akreditasi.index', compact('akreditasi', 'stats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'program_studi'      => 'required|string|max:255',
            'jenjang'            => 'required|in:D3,S1,S2,S3,Profesi',
            'status_akreditasi'  => 'required|string|max:50',
            'lembaga_akreditasi' => 'nullable|string|max:100',
            'nomor_sk'           => 'nullable|string|max:100',
            'tanggal_sk'         => 'nullable|date',
            'masa_berlaku'       => 'nullable|date',
            'link_bukti'         => 'nullable|url|max:500',
        ]);
        Akreditasi::create($data);
        return back()->with('success', 'Data akreditasi berhasil ditambahkan.');
    }

    public function update(Request $request, Akreditasi $akreditasi)
    {
        $data = $request->validate([
            'program_studi'      => 'required|string|max:255',
            'jenjang'            => 'required|in:D3,S1,S2,S3,Profesi',
            'status_akreditasi'  => 'required|string|max:50',
            'lembaga_akreditasi' => 'nullable|string|max:100',
            'nomor_sk'           => 'nullable|string|max:100',
            'tanggal_sk'         => 'nullable|date',
            'masa_berlaku'       => 'nullable|date',
            'link_bukti'         => 'nullable|url|max:500',
        ]);
        $akreditasi->update($data);
        return back()->with('success', 'Data akreditasi berhasil diperbarui.');
    }

    public function destroy(Akreditasi $akreditasi)
    {
        $akreditasi->delete();
        return back()->with('success', 'Data akreditasi berhasil dihapus.');
    }

    public function create()  { return redirect()->route('akreditasi.index'); }
    public function edit(Akreditasi $akreditasi)  { return redirect()->route('akreditasi.index'); }
    public function show(Akreditasi $akreditasi)  { return redirect()->route('akreditasi.index'); }
}
