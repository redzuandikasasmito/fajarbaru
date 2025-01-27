@extends('../layout/app')

@section('page-title', 'Data Barang')
@section('content')
<div class="container mx-auto p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manajemen Barang</h1>
    </div>

    <!-- Card Input Barang -->
    <div class="card bg-base-100 shadow-xl mb-6">
        <div class="card-body">
            <h2 class="card-title text-lg mb-4">Input Barang Baru</h2>
            
            <form action="{{ route('barang.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Nama Barang -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nama Barang</span>
                        </label>
                        <input type="text" name="nama" 
                            class="input input-bordered @error('nama') input-error @enderror"
                            value="{{ old('nama') }}" 
                            placeholder="Masukkan nama barang">
                        @error('nama')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Barcode -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Barcode</span>
                        </label>
                        <input type="text" name="barcode" 
                            class="input input-bordered @error('barcode') input-error @enderror"
                            value="{{ old('barcode') }}" 
                            placeholder="Masukkan barcode">
                        @error('barcode')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Harga Jual -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Harga Jual</span>
                        </label>
                        <div class="input-group">
                            
                            <input type="number" name="harga_jual" 
                                class="input input-bordered w-full @error('harga_jual') input-error @enderror"
                                value="{{ old('harga_jual') }}" 
                                placeholder="0">
                        </div>
                        @error('harga_jual')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Stok Awal -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Stok Awal</span>
                        </label>
                        <input type="number" name="stok_awal" 
                            class="input input-bordered @error('stok_awal') input-error @enderror"
                            value="{{ old('stok_awal', 0) }}" 
                            placeholder="0">
                        @error('stok_awal')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-add-to-queue text-xl' ></i>
                        Simpan Barang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Card Daftar Barang -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-lg">Daftar Barang</h2>
                
                <!-- Search -->
                <div class="form-control">
                    <div class="input-group">
                        <input type="text" id="searchInput" 
                            class="input input-bordered w-full max-w-xs"
                            placeholder="Cari barang...">
                        <button class="btn btn-square">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Barcode</th>
                            <th>Harga Jual</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $barang)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $barang->nama }}</td>
                                <td>{{ $barang->barcode }}</td>
                                <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                                <td>{{ $barang->stok->quantity ?? 0 }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('barang.edit', $barang->id) }}" 
                                            class="btn btn-sm btn-info text-white">
                                            <i class='bx bx-pencil text-xl' ></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('barang.destroy', $barang->id) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Yakin ingin menghapus barang ini?')"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-error text-white mt-1">
                                                <i class='bx bx-trash text-xl' ></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    Tidak ada data barang
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $barangs->links() }}
            </div>
        </div>
    </div>
</div>



<script>
$(document).ready(function() {
    let searchTimer;
    
    $('#searchInput').on('keyup', function() {
        clearTimeout(searchTimer);
        const searchTerm = $(this).val();
        
        // Menambahkan loading indicator
        if(searchTerm.length > 0) {
            $('.btn-square').html('<span class="loading loading-spinner loading-sm"></span>');
        }

        searchTimer = setTimeout(function() {
            $.ajax({
                url: "{{ route('barang.search') }}",
                type: 'GET',
                data: {
                    q: searchTerm
                },
                success: function(response) {
                    let tbody = $('tbody');
                    tbody.empty();

                    if(response.length === 0) {
                        tbody.append(`
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    Tidak ada data barang yang sesuai
                                </td>
                            </tr>
                        `);
                    } else {
                        response.forEach((barang, index) => {
                            tbody.append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${barang.nama}</td>
                                    <td>${barang.barcode}</td>
                                    <td>Rp ${new Intl.NumberFormat('id-ID').format(barang.harga_jual)}</td>
                                    <td>${barang.stok ? barang.stok.quantity : 0}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="/barang/${barang.id}/edit" 
                                                class="btn btn-sm btn-info text-white">
                                                <i class='bx bx-pencil text-xl'></i>
                                                Edit
                                            </a>
                                            <form action="/barang/${barang.id}" 
                                                method="POST" 
                                                onsubmit="return confirm('Yakin ingin menghapus barang ini?')"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-error text-white mt-1">
                                                    <i class='bx bx-trash text-xl'></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            `);
                        });
                    }

                    // Mengembalikan icon search setelah selesai
                    $('.btn-square').html(`
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    `);
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    // Menampilkan pesan error jika terjadi kesalahan
                    $('tbody').html(`
                        <tr>
                            <td colspan="6" class="text-center py-4 text-error">
                                Terjadi kesalahan saat mencari data
                            </td>
                        </tr>
                    `);
                    
                    // Mengembalikan icon search
                    $('.btn-square').html(`
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    `);
                }
            });
        }, 500); // Delay 500ms
    });
});
</script>

@endsection