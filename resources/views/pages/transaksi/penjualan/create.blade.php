@extends('../layout/app')

@section('page-title', 'Tambah Penjualan')
@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Penjualan</h1>
    </div>

    <form action="{{ route('penjualan.store') }}" method="POST" id="formPenjualan">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            <!-- Card Informasi Penjualan -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-lg mb-4">Informasi Penjualan</h2>
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
                            <div class="label">
                                <span class="label-text-alt"><button type="button" class="btn btn-primary" onclick="modal_customer.showModal()">Tambah Customer</button>
                                </span>
                            </div>
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
                            <div class="label">
                                <span class="label-text-alt"><button type="button" class="btn btn-primary" onclick="modal_sales.showModal()">Tambah Sales</button></span>
                            </div>
                        </div>

                        <!-- Status Pembayaran -->
                        <label class="form-control w-full mt-3">
                            <div class="label">
                                <span class="label-text">Pilih Metode Pembayaran</span>
                            </div>
                            <select id="paymentMethod" name="status_pembayaran" class="select select-bordered w-full" onchange="toggleDPInput()">
                                <option value="0">Cash</option>
                                <option value="1">Kredit</option>
                            </select>
                        </label>
                        
                        <!-- Input DP (disembunyikan saat awal) -->
                        <label class="form-control w-full mt-3" id="dpInput" style="display: none;">
                            <div class="label">
                                <span class="label-text">Down Payment (DP)</span>
                            </div>
                            <input type="number" name="dp" placeholder="Masukkan jumlah DP" class="input input-bordered w-full" step="0.01" min="0" />
                        </label>
                        
                    </div>
                </div>
            </div>

            <!-- Card Input Barang -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="card-title text-lg">Input Barang</h2>
                        <button type="button" class="btn btn-primary btn-sm" onclick="searchBarang()">
                            <i class='bx bx-search text-xl'></i>
                            Cari Barang
                        </button>
                    </div>

                    <!-- Tabel Barang -->
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full" id="tableBarang">
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
                                <tr id="emptyRow">
                                    <td colspan="5" class="text-center py-4">
                                        Belum ada barang ditambahkan
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Total -->
                    <div class="flex justify-end mt-4">
                        <div class="stats shadow">
                            <div class="stat">
                                <div class="stat-title">Total Penjualan</div>
                                <div class="stat-value" id="totalPenjualan">Rp 0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary" id="btnSimpan" disabled>
                    <i class='bx bx-save text-xl'></i>
                    Simpan Penjualan
                </button>
            </div>
        </div>
    </form>

    {{-- Modal Customer --}}
    <dialog id="modal_customer" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Tambah Customer</h3>
            
            <form id="form_tambah_customer" method="POST">
                @csrf
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Nama Customer</span>
                    </div>
                    <input type="text" name="nama" placeholder="Masukkan nama" class="input input-bordered w-full" required />
                </label>

                <label class="form-control w-full mt-3">
                    <div class="label">
                        <span class="label-text">Telepon</span>
                    </div>
                    <input type="tel" name="telepon" placeholder="Masukkan nomor telepon" class="input input-bordered w-full" required />
                </label>

                <label class="form-control w-full mt-3">
                    <div class="label">
                        <span class="label-text">Alamat</span>
                    </div>
                    <textarea name="alamat" placeholder="Masukkan alamat" class="textarea textarea-bordered w-full" required></textarea>
                </label>

                <div class="modal-action">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn" onclick="modal_customer.close()">Tutup</button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- Modal Sales --}}
    <dialog id="modal_sales" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">Tambah Sales</h3>
            
            <form id="form_tambah_sales" method="POST">
                @csrf
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Nama Sales</span>
                    </div>
                    <input type="text" name="nama" placeholder="Masukkan nama" class="input input-bordered w-full" required />
                    
                </label>
    
                <label class="form-control w-full mt-3">
                    <div class="label">
                        <span class="label-text">Telepon</span>
                    </div>
                    <input type="tel" name="telepon" placeholder="Masukkan nomor telepon" class="input input-bordered w-full" required />
                </label>
    
                <label class="form-control w-full mt-3">
                    <div class="label">
                        <span class="label-text">Alamat</span>
                    </div>
                    <textarea name="alamat" placeholder="Masukkan alamat" class="textarea textarea-bordered w-full" required></textarea>
                </label>
    
                <!-- Tambahkan Pilihan Aktif/Tidak Aktif -->
                <label class="form-control w-full mt-3">
                    <div class="label">
                        <span class="label-text">Status</span>
                    </div>
                    <select name="status" class="select select-bordered w-full" required>
                        <option value="aktif">Aktif</option>
                        <option value="tidak_aktif">Tidak Aktif</option>
                    </select>
                </label>
    
                <div class="modal-action">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn" onclick="modal_sales.close()">Tutup</button>
                </div>
            </form>
        </div>
    </dialog>
    

    <!-- Modal Cari Barang -->
    <dialog id="modalCariBarang" class="modal">
        <div class="modal-box w-11/12 max-w-5xl">
            <h3 class="font-bold text-lg mb-4">Cari Barang</h3>
            
            <div class="form-control mb-4">
                <div class="input-group">
                    <input type="text" id="searchBarangInput" 
                        class="input input-bordered w-full"
                        placeholder="Ketik nama atau barcode...">
                    <button class="btn btn-square" id="btnSearch">
                        <i class='bx bx-search text-xl'></i>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Barcode</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="searchResults">
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                Ketik untuk mencari barang
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modal-action">
                <form method="dialog">
                    <button class="btn">Tutup</button>
                </form>
            </div>
        </div>
    </dialog>
</div>

<script>
let items = [];
let searchTimer;

function searchBarang() {
    document.getElementById('modalCariBarang').showModal();
}

function toggleDPInput() {
    let paymentMethod = document.getElementById("paymentMethod").value;
    let dpInput = document.getElementById("dpInput");

    if (paymentMethod === "1") {
        dpInput.style.display = "block"; // Tampilkan jika pilih Kredit
    } else {
        dpInput.style.display = "none"; // Sembunyikan jika pilih Cash
    }
}

$(document).ready(function() {
        $('#customer_id).select2({
            placeholder: "Pilih Customer",
            allowClear: true
        });
    });

$('#searchBarangInput').on('keyup', function() {
    clearTimeout(searchTimer);
    const searchTerm = $(this).val();
    $('#btnSearch').html('<span class="loading loading-spinner loading-sm"></span>');
    searchTimer = setTimeout(function() {
        $.ajax({
            url: "{{ route('penjualan.search-barang') }}",
            type: 'GET',
            data: { q: searchTerm },
            success: function(response) {
                let tbody = $('#searchResults');
                tbody.empty();

                if(response.length === 0) {
                    tbody.append(`
                        <tr>
                            <td colspan="5" class="text-center py-4">
                                Tidak ada barang yang sesuai
                            </td>
                        </tr>
                    `);
                } else {
                    response.forEach((barang) => {
                        tbody.append(`
                            <tr>
                                <td>${barang.nama}</td>
                                <td>${barang.barcode}</td>
                                <td>Rp ${new Intl.NumberFormat('id-ID').format(barang.harga_jual)}</td>
                                <td>${barang.stok ? barang.stok.quantity : 0}</td>
                                <td>
                                    <button type="button" 
                                        onclick="pilihBarang(${JSON.stringify(barang).replace(/"/g, '&quot;')})"
                                        class="btn btn-sm btn-primary">
                                        Pilih
                                    </button>
                                </td>
                            </tr>
                        `);
                    });
                }
                $('#btnSearch').html(`<i class='bx bx-search text-xl'></i>`);
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                $('#searchResults').html(`
                    <tr>
                        <td colspan="5" class="text-center py-4 text-error">
                            Terjadi kesalahan saat mencari data
                        </td>
                    </tr>
                `);
                $('#btnSearch').html(`<i class='bx bx-search text-xl'></i>`);
            }
        });
    }, 500);
});

function pilihBarang(barang) {
    // Cek apakah barang sudah ada
    const existingItem = items.find(item => item.barang_id === barang.id);
    if(existingItem) {
        alert('Barang sudah ditambahkan!');
        return;
    }

    // Tambah barang ke array
    items.push({
        barang_id: barang.id,
        nama: barang.nama,
        harga_jual: barang.harga_jual,
        quantity: 1,
        max_qty: barang.stok ? barang.stok.quantity : 0
    });

    updateTable();
    document.getElementById('modalCariBarang').close();
}

function updateTable() {
    const tbody = $('#tableBarang tbody');
    tbody.empty();

    if(items.length === 0) {
        tbody.append(`
            <tr id="emptyRow">
                <td colspan="5" class="text-center py-4">
                    Belum ada barang ditambahkan
                </td>
            </tr>
        `);
        $('#btnSimpan').prop('disabled', true);
    } else {
        items.forEach((item, index) => {
            tbody.append(`
                <tr>
                    <td>${item.nama}</td>
                    <td>
                        <input type="number" 
                            class="input input-bordered w-24"
                            value="${item.quantity}"
                            min="1"
                            max="${item.max_qty}"
                            onchange="updateQuantity(${index}, this.value)">
                        <input type="hidden" name="items[${index}][barang_id]" value="${item.barang_id}">
                        <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                    </td>
                    <td>Rp ${new Intl.NumberFormat('id-ID').format(item.harga_jual)}</td>
                    <td>Rp ${new Intl.NumberFormat('id-ID').format(item.harga_jual * item.quantity)}</td>
                    <td>
                        <button type="button" 
                            onclick="removeItem(${index})"
                            class="btn btn-sm btn-error">
                            <i class='bx bx-trash'></i>
                        </button>
                    </td>
                </tr>
            `);
        });
        $('#btnSimpan').prop('disabled', false);
    }

    updateTotal();
}

function updateQuantity(index, value) {
    value = parseInt(value);
    if(value < 1) value = 1;
    if(value > items[index].max_qty) {
        alert('Stok tidak mencukupi!');
        value = items[index].max_qty;
    }
    items[index].quantity = value;
    updateTable();
}

function removeItem(index) {
    items.splice(index, 1);
    updateTable();
}

function updateTotal() {
    const total = items.reduce((acc, item) => acc + (item.harga_jual * item.quantity), 0);
    $('#totalPenjualan').text(`Rp ${new Intl.NumberFormat('id-ID').format(total)}`);
}

// Validasi form sebelum submit
$('#formPenjualan').on('submit', function(e) {
    if(items.length === 0) {
        e.preventDefault();
        alert('Tambahkan minimal 1 barang!');
        return false;
    }

    // Cek customer dan sales
    if(!$('select[name="customer_id"]').val() || !$('select[name="sales_id"]').val()) {
        e.preventDefault();
        alert('Pilih customer dan sales terlebih dahulu!');
        return false;
    }

    return confirm('Apakah data sudah benar?');
});

// Handle Customer Form Submission
$('#form_tambah_customer').on('submit', function(e) {
    e.preventDefault();
    
    $.ajax({
        url: "{{ route('customer.simpan') }}",
        type: "POST",
        data: $(this).serialize(),
        dataType: "json", // Tambahkan ini agar respons terbaca sebagai JSON
        success: function(response) {
            if(response.success) {
                // Tambahkan customer ke select dropdown
                $('select[name="customer_id"]').append(
                    `<option value="${response.data.id}">${response.data.nama}</option>`
                );
                
                // Reset form dan tutup modal
                $('#form_tambah_customer')[0].reset();
                modal_customer.close();
                
                // Tampilkan pesan sukses
                // alert(response.message);
                Swal.fire({
            title: "Berhasil",
            text: response.message,
            icon: "success"
            }); // Menggunakan message dari JSON
            }
        },
        error: function(xhr) {
            alert('Terjadi kesalahan saat menambahkan customer!');
            console.error(xhr);
        }
    });
});


// Handle Sales Form Submission
$('#form_tambah_sales').on('submit', function(e) {
    e.preventDefault();
    
    $.ajax({
        url: "{{ route('sales.simpan') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function(response) {
            if(response.success) {
                // Add new sales to select dropdown
                $('select[name="sales_id"]').append(
                    `<option value="${response.data.id}">${response.data.nama}</option>`
                );
                
                // Reset form and close modal
                $('#form_tambah_sales')[0].reset();
                modal_sales.close();
                
                // Show success message
                Swal.fire({
            title: "Berhasil",
            text: response.message,
            icon: "success"
            });
            }
        },
        error: function(xhr) {
            alert('Terjadi kesalahan saat menambahkan sales!');
            console.error(xhr);
        }
    });
});
</script>
@endsection
