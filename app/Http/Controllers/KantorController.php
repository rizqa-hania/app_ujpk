<?php

namespace App\Http\Controllers;

use App\Kantor;
use Illuminate\Http\Request;

class KantorController extends Controller
{
    public function index()
    {
        $data = Kantor::all();
        return view('kantor.index', compact('data'));
    }

    public function create()
    {
        return view('kantor.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nama_kantor'  => 'required|string|max:255',
        'alamat'       => 'nullable|string',
        'latitude'     => 'required|numeric',
        'longitude'    => 'required|numeric',
        'radius_meter' => 'required|integer|min:1',
    ]);

    Kantor::create($validated);

    return redirect()->route('kantor.index');
}

    public function destroy($id)
{
    Kantor::where('kantor_id', $id)->delete();
    return redirect()->route('kantor.index');
}

 
}
