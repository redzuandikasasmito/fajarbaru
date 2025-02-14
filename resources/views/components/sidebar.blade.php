x<div class="drawer-side">
    <label for="my-drawer-2" class="drawer-overlay"></label>
    <aside class="flex flex-col h-full">
        <!-- Logo -->
        <div class="sticky top-0 px-4 py-2.5 border-b bg-white">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center">
                    <img src="{{ asset('assets/img/fajarbaru.png') }}" alt="Logo" class="w-8 h-8 object-contain">
                </div>
                <div class="text-primary">
                    <p class="text-xl font-bold leading-none">POS Fjar Baru</p>
                    <span class="text-xs font-semibold tracking-wide">Point of Sales</span>
                </div>
            </div>
        </div>
        {{-- Menu --}}
        <div class="flex-1 bg-white w-80 border-r overflow-y-auto">
            <nav class="menu p-4 space-y-2.5">
                <li>
                    <a href="" class="flex items-center gap-3 p-3 rounded-lg">
                        <i class='bx bx-home text-xl'></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <div class="divider divider-start"><span class="justify-start">Transaksi</span> </div>
                
                <li>
                    <a href="{{ route('penjualan.index') }}" class="flex items-center gap-3 p-3 text-primary rounded-lg">
                        <i class='bx bx-cart-add text-xl'></i>
                        <span>Penjualan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pembelian.index') }}" class="flex items-center gap-3 p-3 text-primary rounded-lg">
                        <i class='bx bx-cart-download text-xl'></i>
                        <span>Pembelian</span>
                    </a>
                </li>
    
                
                <!-- Data -->
                <div class="divider divider-start"><span class="">Data</span> </div>
                <li>
                    <a href="{{ route('barang.index') }}" class="flex items-center gap-3 p-3 text-primary rounded-lg">
                        <i class='bx bx-box text-xl'></i>
                        <span>Data Barang</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('sales.index') }}" class="flex items-center gap-3 p-3 text-primary rounded-lg">
                        <i class='bx bx-user text-xl'></i>
                        <span>Data Sales</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer.index') }}" class="flex items-center gap-3 p-3 text-primary rounded-lg">
                        <i class='bx bx-group text-xl'></i>
                        <span>Data Customer</span>
                    </a>
                </li>
               {{-- Laporan --}}
                <div class="divider divider-start"><span class="">Laporan</span> </div>
                <li>
                    <a href="" class="flex items-center gap-3 p-3 text-primary rounded-lg">
                        <i class='bx bxs-report text-xl'></i>
                        <span>Laporan Penjualan</span>
                    </a>
                </li>
                <li>
                    <a href="" class="flex items-center gap-3 p-3 text-primary rounded-lg">
                        <i class='bx bxs-report text-xl'></i>
                        <span>Laporan Pembelian</span>
                    </a>
                </li>
                <li>
                    <a href="" class="flex items-center gap-3 p-3 text-primary rounded-lg">
                        <i class='bx bx-wallet text-xl' ></i>
                        <span>Laporan Utang</span>
                    </a>
                </li>
                <li>
                    <a href="" class="flex items-center gap-3 p-3 text-primary rounded-lg">
                        <i class='bx bxs-wallet text-xl' ></i>
                        <span>Laporan Piutang</span>
                    </a>
                </li>



                <div class="divider divider-start"><span class="">Akun</span> </div>
                <li>
                    <a href="" class="flex items-center gap-3 p-3 text-primary rounded-lg">
                        <i class='bx bxs-user-account text-xl' ></i>
                        <span>Tambah Akun</span>
                    </a>
                </li>
                <li>
                    <a href="" class="flex items-center gap-3 p-3 text-primary rounded-lg">
                        <i class='bx bx-universal-access text-xl' ></i>
                        <span>Akses</span>
                    </a>
                </li>
                
               
            </nav>
        </div>
        {{-- Profile --}}
        <div class="sticky bottom-0 w-full">
            <div class="bg-gray-50 p-4">
                <div class="flex items-center gap-3">
                    <div class="avatar">
                        <div class="w-10 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                            <img src="https://ui-avatars.com/api/?name=Admin&background=random" alt="Admin" />
                        </div>
                    </div>
                    <div>
                        <p class="font-semibold">Admin User</p>
                        <p class="text-sm text-gray-500">admin@example.com</p>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>