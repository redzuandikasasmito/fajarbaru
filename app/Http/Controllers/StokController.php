<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use App\Models\Barang;
use Illuminate\Http\Request;

class StokController extends Controller
{
    //
    public function index()
    {
        $stoks = Stok::with('barang')->get();
        return view('admin.showStok', compact('stoks'));
    }
    public function create()
    {
        $barangs = Barang::all();
        return view('admin.stok', compact('barangs'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'quantity' => 'required|integer|min:0'
        ]);

        try {
            Stok::create($validatedData);
            return redirect()->route('stok.index')->with('success', 'Stok berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan stok')->withInput();
        }
    }

    public function updateQuantity(Request $request, Stok $stok)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        try {
            $stok->update([
                'quantity' => $request->quantity
            ]);
            return redirect()->route('stok.index')->with('success', 'Stok berhasil diperbarui');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui stok');
        }
    }

    public function destroy(Stok $stok)
    {
        try {
            $stok->delete();
            return redirect()->route('stok.index')->with('success', 'Stok berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus stok');
        }
    }
}
