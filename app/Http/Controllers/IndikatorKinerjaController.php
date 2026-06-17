<?php

namespace App\Http\Controllers;

use App\Models\IndikatorKinerja;
use App\Models\KategoriIndikator;
use Illuminate\Http\Request;

class IndikatorKinerjaController extends Controller
{
    public function index(Request $request)
    {
        $query = IndikatorKinerja::with('kategori');

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_indikator', 'like', '%' . $request->search . '%')
                  ->orWhere('nama_indikator', 'like', '%' . $request->search . '%');
            });
        }

        $indikator = $query->orderBy('kode_indikator')->paginate(15)->withQueryString();
        $kategoris  = KategoriIndikator::orderBy('nama_kategori')->get();

        return view('indikator.index', compact('indikator', 'kategoris'));
    }

    public function create()
    {
        $kategoris = KategoriIndikator::orderBy('nama_kategori')->get();
        return view('indikator.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_indikator'   => 'required|string|max:20|unique:indikator_kinerja',
            'nama_indikator'   => 'required|string|max:255',
            'kategori_id'      => 'required|exists:kategori_indikator,id',
            'target'           => 'required|numeric|min:0',
            'satuan'           => 'required|string|max:50',
            'bobot'            => 'required|numeric|min:0|max:100',
            'formula_penilaian'=> 'nullable|string',
            'status'           => 'required|in:aktif,nonaktif',
        ]);

        IndikatorKinerja::create($validated);

        return redirect()->route('indikator.index')
            ->with('success', 'Indikator kinerja berhasil ditambahkan.');
    }

    public function edit(IndikatorKinerja $indikator)
    {
        $kategoris = KategoriIndikator::orderBy('nama_kategori')->get();
        return view('indikator.edit', compact('indikator', 'kategoris'));
    }

    public function update(Request $request, IndikatorKinerja $indikator)
    {
        $validated = $request->validate([
            'kode_indikator'   => 'required|string|max:20|unique:indikator_kinerja,kode_indikator,' . $indikator->id,
            'nama_indikator'   => 'required|string|max:255',
            'kategori_id'      => 'required|exists:kategori_indikator,id',
            'target'           => 'required|numeric|min:0',
            'satuan'           => 'required|string|max:50',
            'bobot'            => 'required|numeric|min:0|max:100',
            'formula_penilaian'=> 'nullable|string',
            'status'           => 'required|in:aktif,nonaktif',
        ]);

        $indikator->update($validated);

        return redirect()->route('indikator.index')
            ->with('success', 'Indikator kinerja berhasil diperbarui.');
    }

    public function destroy(IndikatorKinerja $indikator)
    {
        if ($indikator->realisasi()->count() > 0) {
            return back()->with('error', 'Indikator tidak dapat dihapus karena sudah memiliki data realisasi.');
        }

        $indikator->delete();

        return redirect()->route('indikator.index')
            ->with('success', 'Indikator kinerja berhasil dihapus.');
    }

    public function show(IndikatorKinerja $indikator)
    {
        $indikator->load(['kategori', 'realisasi' => fn($q) => $q->orderBy('tahun')->orderBy('triwulan')]);
        return view('indikator.show', compact('indikator'));
    }
}
