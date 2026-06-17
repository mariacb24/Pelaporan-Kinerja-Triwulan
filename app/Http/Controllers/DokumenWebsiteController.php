<?php
namespace App\Http\Controllers;
use App\Models\DokumenWebsite;
use Illuminate\Http\Request;

class DokumenWebsiteController extends Controller
{
    public function index(Request $request)
    {
        $query = DokumenWebsite::query();
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('search')) $query->where('nama_dokumen', 'like', '%'.$request->search.'%');
        $dokumen = $query->orderBy('nama_dokumen')->paginate(15)->withQueryString();
        return view('dokumen.website', compact('dokumen'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'kategori'     => 'required|string|max:100',
            'url_dokumen'  => 'nullable|url|max:500',
            'tahun'        => 'required|digits:4',
            'status'       => 'required|in:tersedia,tidak_tersedia',
            'keterangan'   => 'nullable|string',
        ]);
        DokumenWebsite::create($data);
        return back()->with('success', 'Dokumen berhasil ditambahkan.');
    }
    public function update(Request $request, DokumenWebsite $website)
    {
        $data = $request->validate([
            'nama_dokumen' => 'required|string|max:255',
            'kategori'     => 'required|string|max:100',
            'url_dokumen'  => 'nullable|url|max:500',
            'tahun'        => 'required|digits:4',
            'status'       => 'required|in:tersedia,tidak_tersedia',
            'keterangan'   => 'nullable|string',
        ]);
        $website->update($data);
        return back()->with('success', 'Dokumen berhasil diperbarui.');
    }
    public function destroy(DokumenWebsite $website)
    {
        $website->delete();
        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
    public function create() { return view('dokumen.website'); }
    public function edit(DokumenWebsite $website) { return view('dokumen.website', compact('website')); }
    public function show(DokumenWebsite $website) { return view('dokumen.website', compact('website')); }
}
