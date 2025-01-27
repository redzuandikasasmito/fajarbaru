@extends('../layout/app')

@section('page-title', 'Detail Penjualan')
@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Penjualan</h1>
        <a href="{{ route('penjualan.index') }}" class="btn btn-outline">
            <i class='bx bx-arrow-back text-xl'></i>
            Kembali
        </a>
    </div>

    <!-- Card Informasi Penjualan -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-lg mb-4">Informasi Penjualan</h2>
                
                <div class="overflow-x-auto">
                    <table class="table">
                        <tr>
                            <td class="font-bold">No Transaksi</td>
                            <td>{{ $penjualan->id }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">Tanggal</td>
                            <td>{{ $penjualan->tanggal->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">Status Pembayaran</td>
                            <td>
                                <span class="badge {{ $penjualan->status_pembayaran == 'cash' ? 'badge-success' : 'badge-warning' }}">
                                    {{ ucfirst($penjualan->status_pembayaran) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-lg mb-4">Informasi Customer & Sales</h2>
                
                <div class="overflow-x-auto">
                    <table class="table">
                        <tr>
                            <td class="font-bold">Customer</td>
                            <td>{{ $penjualan->customer->nama }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">Telepon Customer</td>
                            <td>{{ $penjualan->customer->telepon }}</td>
                        </tr>
                        <tr>
                            <td class="font-bold">Sales</td>
                            <td>{{ $penjualan->sales->nama }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Detail Barang -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title text-lg mb-4">Detail Barang</h2>

            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Quantity</th>
                            <th class="text-right">Harga</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penjualan->details as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $detail->barang->nama }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td class="text-right">Rp {{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
                                <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right font-bold">Total</td>
                            <td class="text-right font-bold">Rp {{ number_format($penjualan->total_penjualan, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection