<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Barang;
use Illuminate\Http\Request;

class StokController extends Controller
{
    // StokController.php
    public function index()
    {
        $stoks = Stok::with('barang')
            ->latest()
            ->paginate(10);
        return view('pages.data.stok', compact('stoks'));
    }

    public function search(Request $request)
    {
        $search = $request->get('q');

        $stoks = Stok::whereHas('barang', function ($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('barcode', 'like', "%{$search}%");
        })->with('barang')->get();

        return response()->json($stoks);
    }
}
