<!-- resources/views/supplier/index.blade.php -->
@extends('../layout/app')

@section('page-title', 'Data Supplier')
@section('content')
<div class="container mx-auto p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Supplier</h1>
    </div>

    <!-- Card Input Supplier -->
    <div class="card bg-base-100 shadow-xl mb-6">
        <div class="card-body">
            <h2 class="card-title text-lg mb-4">Input Supplier</h2>
            
            <form action="{{ route('supplier.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Nama Vendor -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nama Vendor</span>
                        </label>
                        <input type="text" name="nama_vendor" 
                            class="input input-bordered @error('nama_vendor') input-error @enderror"
                            value="{{ old('nama_vendor') }}" 
                            placeholder="Masukkan nama vendor">
                        @error('nama_vendor')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Kontak -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nomor Kontak</span>
                        </label>
                        <input type="text" name="kontak" 
                            class="input input-bordered @error('kontak') input-error @enderror"
                            value="{{ old('kontak') }}" 
                            placeholder="Masukkan kontak">
                        @error('kontak')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Alamat -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Alamat</span>
                        </label>
                        <textarea name="alamat" 
                            class="textarea textarea-bordered @error('alamat') textarea-error @enderror"
                            placeholder="Masukkan alamat">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-plus text-xl'></i>
                        Tambah Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Card Daftar Supplier -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-lg">Daftar Supplier</h2>
                
                <!-- Search -->
                <div class="form-control">
                    <div class="input-group">
                        <input type="text" id="searchInput" 
                            class="input input-bordered w-full max-w-xs"
                            placeholder="Cari supplier...">
                        <button class="btn btn-square">
                            <i class='bx bx-search text-xl'></i>
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
                            <th>Nama Vendor</th>
                            <th>Kontak</th>
                            
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $supplier)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $supplier->nama_vendor }}</td>
                                <td>{{ $supplier->kontak }}</td>
                                
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('supplier.edit', $supplier->id) }}" 
                                            class="btn btn-sm btn-info text-white">
                                            <i class='bx bx-pencil text-xl'></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('supplier.destroy', $supplier->id) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Yakin ingin menghapus supplier ini?')"
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
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    Tidak ada data supplier
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $suppliers->links() }}
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
        
        $('.btn-square').html('<span class="loading loading-spinner loading-sm"></span>');

        searchTimer = setTimeout(function() {
            if(searchTerm.length === 0) {
                window.location.reload();
                return;
            }

            $.ajax({
                url: "{{ route('supplier.search') }}",
                type: 'GET',
                data: { q: searchTerm },
                success: function(response) {
                    let tbody = $('tbody');
                    tbody.empty();

                    if(response.length === 0) {
                        tbody.append(`
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    Tidak ada data supplier yang sesuai
                                </td>
                            </tr>
                        `);
                    } else {
                        response.forEach((supplier, index) => {
                            tbody.append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${supplier.nama_vendor}</td>
                                    <td>${supplier.kontak}</td>
                                    
                                    <td>
                                        <div class="btn-group">
                                            <a href="/supplier/${supplier.id}/edit" 
                                                class="btn btn-sm btn-info text-white">
                                                <i class='bx bx-pencil text-xl'></i>
                                                Edit
                                            </a>
                                            <form action="/supplier/${supplier.id}" 
                                                method="POST" 
                                                onsubmit="return confirm('Yakin ingin menghapus supplier ini?')"
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
                    $('.btn-square').html(`<i class='bx bx-search text-xl'></i>`);
                },
                error: function(xhr) {
                    console.error('Error:', xhr);
                    $('tbody').html(`
                        <tr>
                            <td colspan="5" class="text-center py-4 text-error">
                                Terjadi kesalahan saat mencari data
                            </td>
                        </tr>
                    `);
                    $('.btn-square').html(`<i class='bx bx-search text-xl'></i>`);
                }
            });
        }, 500);
    });
});
</script>

@endsection