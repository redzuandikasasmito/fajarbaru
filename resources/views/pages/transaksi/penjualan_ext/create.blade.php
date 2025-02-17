<!-- resources/views/penjualan/create.blade.php -->
@extends('../layout/app')

@section('page-title', 'Tambah Penjualan')
@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Penjualan</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('penjualan_ext.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            <!-- Card Informasi Penjualan -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-lg mb-4">Informasi Penjualan</h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-1 gap-3 mb-4">
                        <button type="button" class="btn btn-primary" onclick="modal_customer.showModal()">Tambah Customer</button>
                        <button type="button" class="btn btn-primary" onclick="modal_sales.showModal()">Tambah Sales</button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Customer -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Customer</span>
                            </label>
                            <select name="customer_id" class="select select-bordered" required>
                                <option value="">Pilih Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                       
                        <!-- Sales -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Sales</span>
                            </label>
                            <select name="sales_id" class="select select-bordered" required>
                                <option value="">Pilih Sales</option>
                                @foreach($sales as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Pembayaran -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Status Pembayaran</span>
                            </label>
                            <select name="status_pembayaran" class="select select-bordered" required>
                                <option value="0">Cash</option>
                                <option value="1">Kredit</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Customer -->
            <dialog id="modal_customer" class="modal">
                <div class="modal-box">
                    <h3 class="font-bold text-lg mb-4">Tambah Customer Baru</h3>
                    <form action="{{ route('customer.store') }}" method="POST">
                        @csrf
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Nama Customer</span>
                            </label>
                            <input type="text" name="nama" class="input input-bordered" required>
                        </div>

                        <div class="form-control mt-4">
                            <label class="label">
                                <span class="label-text">Telepon</span>
                            </label>
                            <input type="tel" name="telepon" class="input input-bordered" required>
                        </div>

                        <div class="form-control mt-4">
                            <label class="label">
                                <span class="label-text">Alamat</span>
                            </label>
                            <textarea name="alamat" class="textarea textarea-bordered" required></textarea>
                        </div>

                        <div class="modal-action">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn" onclick="modal_customer.close()">Tutup</button>
                        </div>
                    </form>
                </div>
            </dialog>

            <!-- Modal Sales -->
            <dialog id="modal_sales" class="modal">
                <div class="modal-box">
                    <h3 class="font-bold text-lg mb-4">Tambah Sales Baru</h3>
                    <form action="{{ route('sales.store') }}" method="POST">
                        @csrf
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Nama Sales</span>
                            </label>
                            <input type="text" name="nama" class="input input-bordered" required>
                        </div>

                        <div class="form-control mt-4">
                            <label class="label">
                                <span class="label-text">Telepon</span>
                            </label>
                            <input type="tel" name="telepon" class="input input-bordered" required>
                        </div>

                        <div class="form-control mt-4">
                            <label class="label">
                                <span class="label-text">Alamat</span>
                            </label>
                            <textarea name="alamat" class="textarea textarea-bordered" required></textarea>
                        </div>

                        <div class="modal-action">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <button type="button" class="btn" onclick="modal_sales.close()">Tutup</button>
                        </div>
                    </form>
                </div>
            </dialog>

            <!-- Card Input Barang -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-lg mb-4">Input Barang</h2>
                    
                    <!-- Form Tambah Barang -->
                    <form action="{{ route('penjualan_ext.add-item') }}" method="POST" class="mb-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <select name="barang_id" class="select select-bordered" required>
                                <option value="">Pilih Barang</option>
                                @foreach($barang as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->nama }} - Stok: {{ $item->stok->quantity ?? 0 }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                        </div>
                    </form>

                    <!-- Tabel Barang -->
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse(session('cart', []) as $index => $item)
                                    <tr>
                                        <td>{{ $item['nama'] }}</td>
                                        <td>
                                            <form action="{{ route('penjualan_ext.update-quantity') }}" method="POST" class="flex gap-2">
                                                @csrf
                                                <input type="hidden" name="index" value="{{ $index }}">
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}"
                                                    min="1" max="{{ $item['max_qty'] }}"
                                                    class="input input-bordered w-20">
                                                <button type="submit" class="btn btn-sm">Update</button>
                                            </form>
                                        </td>
                                        <td>Rp {{ number_format($item['harga_jual']) }}</td>
                                        <td>Rp {{ number_format($item['harga_jual'] * $item['quantity']) }}</td>
                                        <td>
                                            <form action="{{ route('penjualan_ext.remove-item', $index) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-error btn-sm">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">Keranjang kosong</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Total -->
                    <div class="flex justify-end mt-4">
                        <div class="stats shadow">
                            <div class="stat">
                                <div class="stat-title">Total Penjualan</div>
                                <div class="stat-value">
                                    Rp {{ number_format(collect(session('cart', []))->sum(fn($item) => $item['harga_jual'] * $item['quantity'])) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary" {{ empty(session('cart')) ? 'disabled' : '' }}>
                    Simpan Penjualan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection