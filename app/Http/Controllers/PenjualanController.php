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
            'customer_id' => 'required',
            'sales_id' => 'required',
            'status_pembayaran' => 'required',
            'items' => 'required|array',
            'items.*.barang_id' => 'required',
            'items.*.quantity' => 'required|integer|min:1',
            'dp' => 'nullable|numeric|min:0', // DP harus angka dan minimal 0
        ]);

        try {
            DB::beginTransaction();

            // Data untuk `penjualans`
            $penjualanData = [
                'customer_id' => $requestValidated['customer_id'],
                'sales_id' => $requestValidated['sales_id'],
                'status_pembayaran' => $requestValidated['status_pembayaran'] == '0' ? 'cash' : 'kredit',
                'total_penjualan' => 0, // Akan dihitung nanti
                'tanggal' => now(),
            ];

            // Simpan ke tabel `penjualans`
            $penjualanId = DB::table('penjualans')->insertGetId($penjualanData);

            $total = 0;

            // Iterasi setiap item
            foreach ($requestValidated['items'] as $item) {
                // Ambil harga jual
                $barang = DB::table('barangs')->where('id', $item['barang_id'])->first();
                if (!$barang) {
                    throw new \Exception('Barang tidak ditemukan.');
                }

                $hargaJual = $barang->harga_jual;
                $subtotal = $item['quantity'] * $hargaJual;
                $total += $subtotal;

                // Simpan ke `detail_penjualans`
                DB::table('detail_penjualans')->insert([
                    'penjualan_id' => $penjualanId,
                    'barang_id' => $item['barang_id'],
                    'quantity' => $item['quantity'],
                    'harga_jual' => $hargaJual,
                    'subtotal' => $subtotal,
                ]);

                // Cek stok sebelum mengurangi
                $stok = DB::table('stoks')->where('barang_id', $item['barang_id'])->value('quantity');
                if ($stok < $item['quantity']) {
                    throw new \Exception('Stok barang tidak mencukupi.');
                }

                // Kurangi stok
                DB::table('stoks')
                    ->where('barang_id', $item['barang_id'])
                    ->decrement('quantity', $item['quantity']);
            }

            // Update total di `penjualans`
            DB::table('penjualans')
                ->where('id', $penjualanId)
                ->update(['total_penjualan' => $total]);

            // Jika status pembayaran adalah 'kredit', buat piutang
            if ($requestValidated['status_pembayaran'] == '1') {
                $jatuhTempo = now()->addMonth(); // Jatuh tempo 1 bulan setelah penjualan

                // Hitung total piutang setelah dikurangi DP
                $totalPiutang = $total - ($requestValidated['dp'] ?? 0);

                DB::table('piutangs')->insert([
                    'penjualan_id' => $penjualanId,
                    'customer_id' => $requestValidated['customer_id'],
                    'total_piutang' => $totalPiutang,
                    'jatuh_tempo' => $jatuhTempo,
                    'dp' => $requestValidated['dp'] ?? 0,
                    'status' => 'belum lunas',
                ]);
            }

            DB::commit();

            // Response JSON sukses
            return response()->json([
                'success' => true,
                'code' => 200,
                'message' => 'Data penjualan berhasil disimpan.',
                'data' => [
                    'penjualan_id' => $penjualanId,
                    'total_penjualan' => $total
                ]
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();

            // Response JSON error
            return response()->json([
                'success' => false,
                'code' => 500,
                'message' => 'Terjadi kesalahan pada server.',
                'error' => $e->getMessage()
            ], 500);
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
