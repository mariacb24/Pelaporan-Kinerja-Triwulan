<?php
namespace App\Http\Controllers;
use App\Models\Role; use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index() { $roles = Role::withCount('users')->get(); return view('users.roles', compact('roles')); }
    public function store(Request $request) {
        $request->validate(['name'=>'required|string|max:50|unique:roles','display_name'=>'required|string|max:100','description'=>'nullable|string']);
        Role::create($request->only(['name','display_name','description']));
        return back()->with('success','Role berhasil ditambahkan.');
    }
    public function update(Request $request, Role $role) {
        $request->validate(['display_name'=>'required|string|max:100','description'=>'nullable|string']);
        $role->update($request->only(['display_name','description']));
        return back()->with('success','Role berhasil diperbarui.');
    }
    public function destroy(Role $role) {
        if ($role->users()->count()) return back()->with('error','Role masih digunakan oleh user.');
        $role->delete(); return back()->with('success','Role berhasil dihapus.');
    }
    public function create() { return redirect()->route('roles.index'); }
    public function edit(Role $role) { return redirect()->route('roles.index'); }
    public function show(Role $role) { return redirect()->route('roles.index'); }
}
