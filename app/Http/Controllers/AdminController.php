<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AdminController extends Controller
{
    // TAMPILKAN LIST ADMIN
    public function index()
    {
        $admins = User::where('role','admin')->get();
        return view('admin.index', compact('admins'));
        
    }

    public function create()
    {
        return view('admin.create');
    }

    // FORM CREATE
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin'
        ]);
        return redirect()->route('admin.index')
        ->with('success','admin berhasil disimpan');
    }
    // HAPUS ADMIN
   public function destroy($id)
    {
        $admin = User::findOrFail($id);

        // Tidak boleh hapus super admin
        if($admin->role !== 'admin'){
            return back()->with('error','Tidak bisa menghapus user ini');
        }

        $admin->delete();

        return back()->with('success','Admin berhasil dihapus');
    }

}