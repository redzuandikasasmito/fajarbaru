<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index()
    {
        // Ambil data barang dengan stoknya
        $barangs = Barang::with('stok')
            ->latest()
            ->paginate(10);

        return view('pages/data/data_barang', compact('barangs'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'barcode' => 'required|string|unique:barangs,barcode',
            'harga_jual' => 'required|numeric|min:0',
            'stok_awal' => 'required|integer|min:0'
        ]);

        DB::beginTransaction();
        try {
            // Simpan data barang
            $barang = Barang::create([
                'nama' => $request->nama,
                'barcode' => $request->barcode,
                'harga_jual' => $request->harga_jual
            ]);

            // Buat stok awal
            Stok::create([
                'barang_id' => $barang->id,
                'quantity' => $request->stok_awal
            ]);

            DB::commit();
            return redirect()->route('barang.index')
                ->with('success', 'Barang berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function show(Barang $barang)
    {
        // Load relasi yang diperlukan
        $barang->load('stok', 'detailPembelians.pembelian', 'detailPenjualans.penjualan');

        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $barang->load('stok');
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'barcode' => 'required|string|unique:barangs,barcode,' . $barang->id,
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0'
        ]);

        DB::beginTransaction();
        try {
            // Update data barang
            $barang->update([
                'nama' => $request->nama,
                'barcode' => $request->barcode,
                'harga_jual' => $request->harga_jual
            ]);

            // Update stok
            $barang->stok()->update([
                'quantity' => $request->stok
            ]);

            DB::commit();
            return redirect()->route('barang.index')
                ->with('success', 'Barang berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy(Barang $barang)
    {
        try {
            $barang->delete();
            return redirect()->route('barang.index')
                ->with('success', 'Barang berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Tidak dapat menghapus barang karena masih terkait dengan transaksi.');
        }
    }

    public function search(Request $request)
    {
        $search = $request->get('q');

        $barangs = Barang::where('nama', 'like', "%{$search}%")
            ->orWhere('barcode', 'like', "%{$search}%")
            ->with('stok')
            ->get();

        return response()->json($barangs);
    }
}
