<?php
namespace App\Http\Controllers;
use App\Models\Survei; use App\Models\KepuasanMahasiswa; use Illuminate\Http\Request;

class SurveiController extends Controller
{
    public function index(Request $request) {
        $survei = Survei::orderByDesc('tahun')->paginate(15);
        $kepuasan = KepuasanMahasiswa::where('tahun', $request->get('tahun', now()->year))->get();
        return view('survei.index', compact('survei', 'kepuasan'));
    }
    public function store(Request $request) {
        $request->validate(['nama_survei'=>'required|string|max:255','tahun'=>'required|digits:4','url_hasil'=>'nullable|url','jumlah_responden'=>'nullable|integer|min:0','keterangan'=>'nullable|string']);
        Survei::create($request->only(['nama_survei','tahun','triwulan','url_hasil','jumlah_responden','keterangan']));
        return back()->with('success','Survei berhasil ditambahkan.');
    }
    public function update(Request $request, Survei $survei) {
        $survei->update($request->only(['nama_survei','tahun','triwulan','url_hasil','jumlah_responden','keterangan']));
        return back()->with('success','Survei berhasil diperbarui.');
    }
    public function destroy(Survei $survei) { $survei->delete(); return back()->with('success','Survei dihapus.'); }
    public function create() { return redirect()->route('survei.index'); }
    public function edit(Survei $survei) { return redirect()->route('survei.index'); }
    public function show(Survei $survei) { return redirect()->route('survei.index'); }
}
