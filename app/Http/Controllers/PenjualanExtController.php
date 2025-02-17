<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\Sales;
use Illuminate\Support\Facades\DB;
use App\Models\Penjualan;

class PenjualanExtController extends Controller
{
    public function create()
    {
        $customers = Customer::all();
        $sales = Sales::all();
        $barang = Barang::with('stok')->get();

        // Initialize cart in session if not exists
        if (!session()->has('cart')) {
            session(['cart' => []]);
        }

        return view('pages.transaksi.penjualan_ext.create', compact('customers', 'sales', 'barang'));
    }

    public function addItem(Request $request)
    {
        $barang = Barang::with('stok')->findOrFail($request->barang_id);
        $cart = session('cart', []);

        // Check if item already exists in cart
        foreach ($cart as $item) {
            if ($item['barang_id'] == $barang->id) {
                return redirect()->back()->with('error', 'Barang sudah ada di keranjang!');
            }
        }

        // Add item to cart
        $cart[] = [
            'barang_id' => $barang->id,
            'nama' => $barang->nama,
            'harga_jual' => $barang->harga_jual,
            'quantity' => 1,
            'max_qty' => $barang->stok->quantity ?? 0
        ];

        session(['cart' => $cart]);
        return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }

    public function removeItem($index)
    {
        $cart = session('cart', []);
        if (isset($cart[$index])) {
            unset($cart[$index]);
            $cart = array_values($cart); // Reindex array
        }
        session(['cart' => $cart]);
        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }

    public function updateQuantity(Request $request)
    {
        $index = $request->index;
        $quantity = $request->quantity;
        $cart = session('cart', []);

        if (isset($cart[$index])) {
            if ($quantity > $cart[$index]['max_qty']) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi!');
            }

            if ($quantity < 1) {
                $quantity = 1;
            }

            $cart[$index]['quantity'] = $quantity;
            session(['cart' => $cart]);
            return redirect()->back()->with('success', 'Jumlah berhasil diupdate!');
        }

        return redirect()->back()->with('error', 'Barang tidak ditemukan!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'sales_id' => 'required|exists:sales,id',
            'status_pembayaran' => 'required|in:0,1',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        try {
            DB::beginTransaction();

            // Create penjualan
            $penjualan = Penjualan::create([
                'customer_id' => $request->customer_id,
                'sales_id' => $request->sales_id,
                'status_pembayaran' => $request->status_pembayaran,
                'total' => collect($cart)->sum(fn($item) => $item['harga_jual'] * $item['quantity'])
            ]);

            // Create penjualan items
            foreach ($cart as $item) {
                $penjualan->items()->create([
                    'barang_id' => $item['barang_id'],
                    'quantity' => $item['quantity'],
                    'harga_jual' => $item['harga_jual']
                ]);

                // Update stock
                $barang = Barang::find($item['barang_id']);
                $barang->stok()->decrement('quantity', $item['quantity']);
            }

            DB::commit();
            session()->forget('cart'); // Clear cart
            return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
