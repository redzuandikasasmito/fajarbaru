
@extends('../layout/app')

@section('page-title', 'Data Sales')
@section('content')
<div class="container mx-auto p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Sales</h1>
    </div>

    <!-- Card Input Sales -->
    <div class="card bg-base-100 shadow-xl mb-6">
        <div class="card-body">
            <h2 class="card-title text-lg mb-4">Input Sales</h2>
            
            <form action="{{ route('sales.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Nama -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nama Sales</span>
                        </label>
                        <input type="text" name="nama" 
                            class="input input-bordered @error('nama') input-error @enderror"
                            value="{{ old('nama') }}" 
                            placeholder="Masukkan nama">
                        @error('nama')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>

                    <!-- Telepon -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Nomor Telepon</span>
                        </label>
                        <input type="text" name="telepon" 
                            class="input input-bordered @error('telepon') input-error @enderror"
                            value="{{ old('telepon') }}" 
                            placeholder="Masukkan telepon">
                        @error('telepon')
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

                    <!-- Status -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Status</span>
                        </label>
                        <select name="status" class="select select-bordered @error('status') select-error @enderror">
                            <option value="">Pilih Status</option>
                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
                        </select>
                        @error('status')
                            <label class="label">
                                <span class="label-text-alt text-error">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-user-plus text-xl'></i>
                        Tambah Sales
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Card Daftar Sales -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between items-center mb-4">
                <h2 class="card-title text-lg">Daftar Sales</h2>
                
                <!-- Search -->
                <div class="form-control">
                    <div class="input-group">
                        <input type="text" id="searchInput" 
                            class="input input-bordered w-full max-w-xs"
                            placeholder="Cari sales...">
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
                            <th>Nama</th>
                            <th>Telepon</th>
                            <th>Alamat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->telepon }}</td>
                                <td>{{ $item->alamat }}</td>
                                <td>
                                    <span class="badge {{ $item->status == 'aktif' ? 'badge-success' : 'badge-error' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('sales.edit', $item->id) }}" 
                                            class="btn btn-sm btn-info text-white">
                                            <i class='bx bx-pencil text-xl'></i>
                                            Edit
                                        </a>
                                        <form action="{{ route('sales.destroy', $item->id) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Yakin ingin menghapus sales ini?')"
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
                                <td colspan="6" class="text-center py-4">
                                    Tidak ada data sales
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $sales->links() }}
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
                url: "{{ route('sales.search') }}",
                type: 'GET',
                data: { q: searchTerm },
                success: function(response) {
                    let tbody = $('tbody');
                    tbody.empty();

                    if(response.length === 0) {
                        tbody.append(`
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    Tidak ada data sales yang sesuai
                                </td>
                            </tr>
                        `);
                    } else {
                        response.forEach((item, index) => {
                            const statusBadge = item.status === 'aktif' ? 
                                'badge-success' : 'badge-error';
                            
                            tbody.append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.nama}</td>
                                    <td>${item.telepon}</td>
                                    <td>${item.alamat}</td>
                                    <td>
                                        <span class="badge ${statusBadge}">
                                            ${item.status.charAt(0).toUpperCase() + item.status.slice(1)}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="/sales/${item.id}/edit" 
                                                class="btn btn-sm btn-info text-white">
                                                <i class='bx bx-pencil text-xl'></i>
                                                Edit
                                            </a>
                                            <form action="/sales/${item.id}" 
                                                method="POST" 
                                                onsubmit="return confirm('Yakin ingin menghapus sales ini?')"
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
                            <td colspan="6" class="text-center py-4 text-error">
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