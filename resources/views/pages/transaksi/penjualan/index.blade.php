<!-- resources/views/penjualan/index.blade.php -->
@extends('../layout/app')

@section('page-title', 'Data Penjualan')
@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Penjualan</h1>
        <a href="{{ route('penjualan.create') }}" class="btn btn-primary">
            <i class='bx bx-plus text-xl'></i>
            Tambah Penjualan
        </a>
    </div>

    <!-- Daftar Penjualan -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Customer</th>
                            <th>Sales</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penjualans as $penjualan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $penjualan->tanggal->format('d/m/Y H:i') }}</td>
                                <td>{{ $penjualan->customer->nama }}</td>
                                <td>{{ $penjualan->sales->nama }}</td>
                                <td>Rp {{ number_format($penjualan->total_penjualan, 0, ',', '.') }}</td>
                                <td>
                                   {{ $penjualan->status_pembayaran }}
                                </td>
                                <td>
                                    <a href="{{ route('penjualan.show', $penjualan->id) }}" 
                                        class="btn btn-sm btn-info text-white">
                                        <i class='bx bx-detail text-xl'></i>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    Tidak ada data penjualan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $penjualans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection