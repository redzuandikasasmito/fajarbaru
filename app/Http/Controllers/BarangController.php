<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    //
    // public function index()
    // {
    //     return view('admin.barang');
    // }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'barcode' => 'string|max:255',
            'harga_jual' => 'required|integer'

        ]);

        $barang = Barang::create([
            'nama' => $validatedData['nama_barang'],
            'barcode' => $validatedData['barcode'],
            'harga_jual' => $validatedData['harga_jual']
        ]);

        return redirect('/barang')->with('success', 'Barang berhasil ditambahkan');
    }

    public function index()
    {
        $barangs = Barang::all();
        return view('admin.barang', compact('barangs'));
    }

    public function updateBarang(Request $request, Barang $barang)
    {
        $validatedData = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'barcode' => 'string|max:255',
            'harga_jual' => 'required|integer'
        ]);

        $barang->update([
            'nama' => $validatedData['nama_barang'],
            'barcode' => $validatedData['barcode'],
            'harga_jual' => $validatedData['harga_jual']
        ]);

        return redirect('/barang')->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy(Barang $barang)
    {
        try {
            $barang->delete();
            return redirect('/barang')->with('success', 'Barang berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus barang');
        }
    }
}
