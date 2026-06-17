<?php

namespace App\Http\Controllers;

use App\Models\KepuasanMahasiswa;
use Illuminate\Http\Request;

class KepuasanMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', now()->year);
        $kepuasan = KepuasanMahasiswa::where('tahun', $tahun)->orderBy('aspek')->get();
        return view('survei.kepuasan', compact('kepuasan', 'tahun'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'aspek'       => 'required|string|max:100',
            'tidak_puas'  => 'required|numeric|min:0',
            'kurang_puas' => 'required|numeric|min:0',
            'puas'        => 'required|numeric|min:0',
            'sangat_puas' => 'required|numeric|min:0',
            'tahun'       => 'required|digits:4',
        ]);

        $total = $data['tidak_puas'] + $data['kurang_puas'] + $data['puas'] + $data['sangat_puas'];
        $data['skor_rata'] = $total > 0
            ? round(($data['tidak_puas']*1 + $data['kurang_puas']*2 + $data['puas']*3 + $data['sangat_puas']*4) / $total, 2)
            : 0;

        KepuasanMahasiswa::create($data);
        return back()->with('success', 'Data kepuasan berhasil disimpan.');
    }

    public function update(Request $request, KepuasanMahasiswa $kepuasan)
    {
        $data = $request->validate([
            'aspek'       => 'required|string|max:100',
            'tidak_puas'  => 'required|numeric|min:0',
            'kurang_puas' => 'required|numeric|min:0',
            'puas'        => 'required|numeric|min:0',
            'sangat_puas' => 'required|numeric|min:0',
            'tahun'       => 'required|digits:4',
        ]);
        $total = $data['tidak_puas'] + $data['kurang_puas'] + $data['puas'] + $data['sangat_puas'];
        $data['skor_rata'] = $total > 0
            ? round(($data['tidak_puas']*1 + $data['kurang_puas']*2 + $data['puas']*3 + $data['sangat_puas']*4) / $total, 2)
            : 0;
        $kepuasan->update($data);
        return back()->with('success', 'Data kepuasan berhasil diperbarui.');
    }

    public function destroy(KepuasanMahasiswa $kepuasan)
    {
        $kepuasan->delete();
        return back()->with('success', 'Data kepuasan dihapus.');
    }

    public function create()  { return redirect()->route('kepuasan.index'); }
    public function edit(KepuasanMahasiswa $kepuasan)  { return redirect()->route('kepuasan.index'); }
    public function show(KepuasanMahasiswa $kepuasan)  { return redirect()->route('kepuasan.index'); }
}
