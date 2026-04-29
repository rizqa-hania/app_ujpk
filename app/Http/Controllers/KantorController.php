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
    // Hindari error jika user copy-paste menggunakan tanda koma
    if ($request->has('latitude') && $request->has('longitude')) {
        $request->merge([
            'latitude' => str_replace(',', '.', $request->latitude),
            'longitude' => str_replace(',', '.', $request->longitude),
        ]);
    }

    $validated = $request->validate([
        'nama_kantor'  => 'required|string|max:255',
        'alamat'       => 'nullable|string',
        'latitude'     => 'required|numeric|between:-90,90',
        'longitude'    => 'required|numeric|between:-180,180',
        'radius_meter' => 'required|integer|min:1',
    ], [
        'latitude.between' => 'Titik Latitude tidak valid (harus antara -90 sampai 90)',
        'longitude.between' => 'Titik Longitude tidak valid (harus antara -180 sampai 180)',
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
