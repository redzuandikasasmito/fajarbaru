<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Stok;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    //
    // PembelianController.php

    // PembelianController.php
    public function index()
    {
        $pembelians = Pembelian::with(['supplier'])
            ->latest()
            ->paginate(10);
        $suppliers = Supplier::all();
        return view('pages.transaksi.pembelian.index', compact('pembelians', 'suppliers'));
    }
    public function create()
    {
        $suppliers = Supplier::all();
        $barangs = Barang::all();
        return view('pages.transaksi.pembelian.index', compact('suppliers', 'barangs'));
    }

    public function store(Request $request)
    {
        $requestValidated = $request->validate([
            'nomor_nota' => 'required|string|unique:pembelians,nomor_nota',
            'supplier_id' => 'required|exists:suppliers,id',
            'status_pembayaran' => 'required|in:cash,kredit',
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barangs,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.harga_beli' => 'required|numeric|min:0'
        ]);

        try {
            DB::beginTransaction();

            $pembelian = Pembelian::create([
                'nomor_nota' => $requestValidated['nomor_nota'],
                'supplier_id' => $requestValidated['supplier_id'],
                'status_pembayaran' => $requestValidated['status_pembayaran'],
                'total_pembelian' => 0,
                'tanggal' => now()
            ]);

            $total = 0;
            foreach ($requestValidated['items'] as $item) {
                $subtotal = $item['quantity'] * $item['harga_beli'];
                $total += $subtotal;

                DetailPembelian::create([
                    'pembelian_id' => $pembelian->id,
                    'barang_id' => $item['barang_id'],
                    'quantity' => $item['quantity'],
                    'harga_beli' => $item['harga_beli'],
                    'subtotal' => $subtotal
                ]);

                // Update atau buat stok
                $stok = Stok::firstOrCreate(
                    ['barang_id' => $item['barang_id']],
                    ['quantity' => 0]
                );
                $stok->quantity += $item['quantity'];
                $stok->save();
            }

            $pembelian->total_pembelian = $total;
            $pembelian->save();

            DB::commit();
            return redirect()->route('pembelian.index')
                ->with('success', 'Pembelian berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Untuk menyimpan barang baru via modal
    public function storeBarang(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'barcode' => 'required|string|unique:barangs,barcode',
            'harga_jual' => 'numeric|min:0'
        ]);

        $barang = Barang::create($request->all());

        return response()->json([
            'success' => true,
            'barang' => $barang
        ]);
    }
}
