<?php
namespace App\Http\Controllers;
use App\Models\PedomanSop; use Illuminate\Http\Request;

class PedomanSopController extends Controller
{
    public function index(Request $request) {
        $pedoman = PedomanSop::orderBy('nama_pedoman')->paginate(15)->withQueryString();
        return view('dokumen.pedoman', compact('pedoman'));
    }
    public function store(Request $request) {
        $request->validate(['nama_pedoman'=>'required|string|max:255','jenis'=>'required|in:pedoman,sop,panduan','url'=>'nullable|url|max:500','tahun'=>'required|digits:4','status'=>'required|in:aktif,revisi,tidak_aktif']);
        PedomanSop::create($request->only(['nama_pedoman','jenis','url','tahun','status','keterangan']));
        return back()->with('success','Pedoman/SOP berhasil ditambahkan.');
    }
    public function update(Request $request, PedomanSop $pedoman) {
        $pedoman->update($request->only(['nama_pedoman','jenis','url','tahun','status','keterangan']));
        return back()->with('success','Pedoman/SOP berhasil diperbarui.');
    }
    public function destroy(PedomanSop $pedoman) { $pedoman->delete(); return back()->with('success','Pedoman/SOP dihapus.'); }
    public function create() { return redirect()->route('pedoman.index'); }
    public function edit(PedomanSop $pedoman) { return redirect()->route('pedoman.index'); }
    public function show(PedomanSop $pedoman) { return redirect()->route('pedoman.index'); }
}
