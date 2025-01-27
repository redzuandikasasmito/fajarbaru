@extends('layout.app')



@section('content')
    
<div class="grid p-2 lg:grid-cols-4 md:grid-cols-2 sm:grid-cols-1 gap-4">
    <!-- Card Penjualan Biru -->
    <div class="card card-gradient gradient-blue w-full text-white shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-xl font-bold">Penjualan Bulan Ini</h2>
                <i class='bx bx-line-chart text-3xl'></i>
            </div>

            <div class="mb-4">
                <p class="text-sm opacity-75">Total Pendapatan</p>
                <h3 class="text-3xl font-bold">Rp 125.000.000</h3>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm opacity-75">Produk Terjual</p>
                    <div class="flex items-center">
                        <i class='bx bx-cart text-xl mr-2'></i>
                        <span class="text-xl font-semibold">254</span>
                    </div>
                </div>
                <div>
                    <p class="text-sm opacity-75">Pertumbuhan</p>
                    <div class="flex items-center text-green-300">
                        <i class='bx bx-trending-up text-xl mr-2'></i>
                        <span class="text-xl font-semibold">12.5%</span>
                    </div>
                </div>
            </div>

            <div class="card-actions justify-between items-center mt-4">
                <div class="flex items-center">
                    <span class="text-sm opacity-75">Dibandingkan Bulan Lalu</span>
                </div>
                <button class="btn btn-sm btn-ghost text-white border border-white hover:bg-white hover:text-blue-500">
                    Lihat Detail
                </button>
            </div>
        </div>
    </div>

    <!-- Card Penjualan Hijau -->
    <div class="card card-gradient gradient-green w-full text-white shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-xl font-bold">Pembelian Bulan Ini</h2>
                <i class='bx bx-user-plus text-3xl'></i>
            </div>

            <div class="mb-4">
                <p class="text-sm opacity-75">Total Pembelian</p>
                <h3 class="text-3xl font-bold">Rp. 12.500.000</h3>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm opacity-75">Pembelian Produk</p>
                    <div class="flex items-center">
                        <i class='bx bx-group text-xl mr-2'></i>
                        <span class="text-xl font-semibold">200</span>
                    </div>
                </div>
                <div>
                    <p class="text-sm opacity-75">Pertumbuhan</p>
                    <div class="flex items-center text-green-300">
                        <i class='bx bx-trending-up text-xl mr-2'></i>
                        <span class="text-xl font-semibold">8.7%</span>
                    </div>
                </div>
            </div>

            <div class="card-actions justify-between items-center mt-4">
                <div class="flex items-center">
                    <span class="text-sm opacity-75">Sejak Bulan Lalu</span>
                </div>
                <button class="btn btn-sm btn-ghost text-white border border-white hover:bg-white hover:text-green-500">
                    Detail Pelanggan
                </button>
            </div>
        </div>
    </div>

    <!-- Card Penjualan Ungu -->
    <div class="card card-gradient gradient-purple w-full text-white shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-xl font-bold">Produk</h2>
                <i class='bx bx-package text-3xl'></i>
            </div>

            <div class="mb-4">
                <p class="text-sm opacity-75">Total Produk</p>
                <h3 class="text-3xl font-bold">1.245 Item</h3>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm opacity-75">Produk Terlaris</p>
                    <div class="flex items-center">
                        <i class='bx bx-star text-xl mr-2'></i>
                        <span class="text-xl font-semibold">Lampu</span>
                    </div>
                </div>
                <div>
                    <p class="text-sm opacity-75">Kategori Utama</p>
                    <div class="flex items-center text-purple-300">
                        <i class='bx bx-category text-xl mr-2'></i>
                        <span class="text-xl font-semibold">Elektronik</span>
                    </div>
                </div>
            </div>

            <div class="card-actions justify-between items-center mt-4">
                <div class="flex items-center">
                    <span class="text-sm opacity-75">Inventori</span>
                </div>
                <button class="btn btn-sm btn-ghost text-white border border-white hover:bg-white hover:text-purple-500">
                    Lihat Stok
                </button>
            </div>
        </div>
    </div>

    <!-- Card Penjualan Merah -->
    <div class="card card-gradient gradient-red w-full text-white shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-xl font-bold">Utang / Piutang</h2>
                <i class='bx bx-error text-3xl'></i>
            </div>

            <div class="mb-4">
                <p class="text-sm opacity-75">Total Utang</p>
                <h3 class="text-3xl font-bold">Rp.1.300.000</h3>
            </div>
            <div class="mb-4">
                <p class="text-sm opacity-75">Total Piutang</p>
                <h3 class="text-3xl font-bold">Rp.2.300.000</h3>
            </div>
            

            <div class="card-actions justify-between items-center mt-4">
                <div class="flex items-center">
                    <span class="text-sm opacity-75">Pembayaran</span>
                </div>
                <button class="btn btn-sm btn-ghost text-white border border-white hover:bg-white hover:text-red-500">
                    Bayar Hutang
                </button>
            </div>
        </div>
    </div>
</div>

@endsection