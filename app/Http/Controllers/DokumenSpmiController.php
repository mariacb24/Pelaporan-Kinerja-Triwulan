<?php
namespace App\Http\Controllers;
use App\Models\DokumenSpmi; use Illuminate\Http\Request;

class DokumenSpmiController extends Controller
{
    public function index(Request $request) {
        $query = DokumenSpmi::query();
        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('search')) $query->where('nama_dokumen','like','%'.$request->search.'%');
        $dokumen = $query->orderBy('nama_dokumen')->paginate(15)->withQueryString();
        return view('dokumen.spmi', compact('dokumen'));
    }
    public function store(Request $request) {
        $request->validate(['nama_dokumen'=>'required|string|max:255','kategori'=>'required|string|max:100','link_drive'=>'nullable|url|max:500','tahun'=>'required|digits:4','status'=>'required|in:lengkap,tidak_lengkap,proses','keterangan'=>'nullable|string']);
        DokumenSpmi::create($request->only(['nama_dokumen','kategori','link_drive','status','tahun','keterangan']));
        return back()->with('success','Dokumen SPMI berhasil ditambahkan.');
    }
    public function update(Request $request, DokumenSpmi $spmi) {
        $spmi->update($request->only(['nama_dokumen','kategori','link_drive','status','tahun','keterangan']));
        return back()->with('success','Dokumen SPMI berhasil diperbarui.');
    }
    public function destroy(DokumenSpmi $spmi) { $spmi->delete(); return back()->with('success','Dokumen SPMI dihapus.'); }
    public function create() { return redirect()->route('dokumen.spmi.index'); }
    public function edit(DokumenSpmi $spmi)  { return redirect()->route('dokumen.spmi.index'); }
    public function show(DokumenSpmi $spmi)  { return redirect()->route('dokumen.spmi.index'); }
}
