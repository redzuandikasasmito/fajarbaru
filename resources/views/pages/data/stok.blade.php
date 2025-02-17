@extends('../layout/app')
@section('page-title', 'Data Stok')
@section('content')
<div class="container mx-auto p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Monitoring Stok</h1>
        
        <!-- Search -->
        <div class="form-control">
            <div class="input-group">
                <input type="text" id="searchInput" 
                    class="input input-bordered w-full max-w-xs"
                    placeholder="Cari barang...">
                <button class="btn btn-square">
                    <i class='bx bx-search text-xl'></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Card Daftar Stok -->
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Barcode</th>
                            <th>Stok Tersedia</th>
                            <th>Terakhir Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stoks as $stok)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $stok->barang->nama }}</td>
                                <td>{{ $stok->barang->barcode }}</td>
                                <td>{{ $stok->quantity }}</td>
                                <td>{{ $stok->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    Tidak ada data stok
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $stoks->links() }}
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
            
            // Tampilkan loading
            $('.btn-square').html('<span class="loading loading-spinner loading-sm"></span>');
    
            searchTimer = setTimeout(function() {
                // Jika input kosong, reload halaman untuk menampilkan semua data
                if(searchTerm.length === 0) {
                    window.location.reload();
                    return;
                }
    
                $.ajax({
                    url: "{{ route('stok.search') }}",
                    type: 'GET',
                    data: { q: searchTerm },
                    success: function(response) {
                        let tbody = $('tbody');
                        tbody.empty();
    
                        if(response.length === 0) {
                            tbody.append(`
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        Tidak ada data stok yang sesuai
                                    </td>
                                </tr>
                            `);
                        } else {
                            response.forEach((stok, index) => {
                                tbody.append(`
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${stok.barang.nama}</td>
                                        <td>${stok.barang.barcode}</td>
                                        <td>${stok.quantity}</td>
                                        <td>${moment(stok.updated_at).format('DD/MM/YYYY HH:mm')}</td>
                                    </tr>
                                `);
                            });
                        }
    
                        // Kembalikan icon search setelah selesai
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
                        // Kembalikan icon search jika terjadi error
                        $('.btn-square').html(`<i class='bx bx-search text-xl'></i>`);
                    }
                });
            }, 500);
        });
    });
    </script>

@endsection