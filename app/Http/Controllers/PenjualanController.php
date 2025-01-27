<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Customer;
use App\Models\Sales;
use App\Models\Barang;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\VarDumper;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualans = Penjualan::with(['customer', 'sales'])
            ->latest()
            ->paginate(10);

        return view('pages.transaksi.penjualan.index', compact('penjualans'));
    }

    public function show(Penjualan $penjualan)
    {
        // Load relasi yang dibutuhkan
        $penjualan->load(['customer', 'sales', 'details.barang']);

        return view('pages.transaksi.penjualan.show', compact('penjualan'));
    }

    public function create()
    {
        $customers = Customer::all();
        $sales = Sales::where('status', 'aktif')->get();
        return view('pages.transaksi.penjualan.create', compact('customers', 'sales'));
    }

    public function store(Request $request)
    {
        $requestValidated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'sales_id' => 'required|exists:sales,id',
            'status_pembayaran' => 'required|in:0,1',
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barangs,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.harga_jual' => 'required|numeric|min:0'
        ]);

        try {
            // Memisahkan data untuk tabel `penjualans`
            $penjualanData = [
                'customer_id' => $requestValidated['customer_id'],
                'sales_id' => $requestValidated['sales_id'],
                'status_pembayaran' => $requestValidated['status_pembayaran'] == '0' ? 'cash' : 'kredit',
                'total_penjualan' => 0, // Akan dihitung nanti
                'tanggal' => now(),
            ];

            // Memisahkan data untuk tabel `detail_penjualans`
            $detailPenjualanData = $requestValidated['items']; // Semua item langsung dipakai

            DB::beginTransaction();

            // Input ke tabel `penjualans` dan mendapatkan ID
            $penjualanId = DB::table('penjualans')->insertGetId($penjualanData);

            $total = 0;

            // Iterasi untuk input ke tabel `detail_penjualans`
            foreach ($detailPenjualanData as $item) {
                $subtotal = $item['quantity'] * $item['harga_jual'];
                $total += $subtotal;

                DB::table('detail_penjualans')->insert([
                    'penjualan_id' => $penjualanId,
                    'barang_id' => $item['barang_id'],
                    'quantity' => $item['quantity'],
                    'harga_jual' => $item['harga_jual'],
                    'subtotal' => $subtotal,
                ]);

                // Mengurangi stok barang
                DB::table('stoks')
                    ->where('barang_id', $item['barang_id'])
                    ->decrement('quantity', $item['quantity']);
            }

            // Update total penjualan
            DB::table('penjualans')
                ->where('id', $penjualanId)
                ->update(['total_penjualan' => $total]);

            DB::commit();

            return redirect()->route('penjualan.index')->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }


    public function searchBarang(Request $request)
    {
        $search = $request->get('q');

        $barangs = Barang::where(function ($query) use ($search) {
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('barcode', 'like', "%{$search}%");
        })
            ->with('stok')
            ->get();

        return response()->json($barangs);
    }
}
