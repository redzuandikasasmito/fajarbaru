@extends('../layout/app')

@section('page-title', 'Tambah Pembelian')
@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Pembelian</h1>
    </div>

    <form action="{{ route('pembelian.store') }}" method="POST" id="formPembelian">
        @csrf
        <div class="grid grid-cols-1 gap-6">
            <!-- Card Informasi Pembelian -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <h2 class="card-title text-lg mb-4">Informasi Pembelian</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Nomor Nota -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Nomor Nota</span>
                            </label>
                            <input type="text" name="nomor_nota" 
                                class="input input-bordered @error('nomor_nota') input-error @enderror"
                                value="{{ old('nomor_nota') }}" 
                                required>
                            @error('nomor_nota')
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <!-- Supplier -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Supplier</span>
                            </label>
                            <select name="supplier_id" class="select select-bordered" required>
                                <option value="">Pilih Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->nama_vendor }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Pembayaran -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Status Pembayaran</span>
                            </label>
                            <select name="status_pembayaran" class="select select-bordered" required>
                                <option value="cash">Cash</option>
                                <option value="kredit">Kredit</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Input Barang -->
            <div class="card bg-base-100 shadow-xl">
                <div class="card-body">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="card-title text-lg">Input Barang</h2>
                        <div>
                            <button type="button" class="btn btn-primary btn-sm mr-2" onclick="tambahBarangBaru()">
                                <i class='bx bx-plus text-xl'></i>
                                Barang Baru
                            </button>
                            <button type="button" class="btn btn-primary btn-sm" onclick="pilihBarang()">
                                <i class='bx bx-cart-add text-xl'></i>
                                Tambah ke Keranjang
                            </button>
                        </div>
                    </div>

                    <!-- Tabel Barang -->
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full" id="tableBarang">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Harga Beli</th>
                                    <th>Qty</th>
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
                                <div class="stat-title">Total Pembelian</div>
                                <div class="stat-value" id="totalPembelian">Rp 0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary" id="btnSimpan" disabled>
                    <i class='bx bx-save text-xl'></i>
                    Simpan Pembelian
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Modal Pilih Barang -->
<dialog id="modalPilihBarang" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Pilih Barang</h3>
        
        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text">Barang</span>
            </label>
            <select id="selectBarang" class="select select-bordered w-full">
                <option value="">Pilih Barang</option>
                @foreach($barangs as $barang)
                    <option value="{{ $barang->id }}" 
                        data-nama="{{ $barang->nama }}">{{ $barang->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text">Harga Beli</span>
            </label>
            <input type="number" id="inputHargaBeli" class="input input-bordered" min="0">
        </div>

        <div class="form-control mb-4">
            <label class="label">
                <span class="label-text">Quantity</span>
            </label>
            <input type="number" id="inputQuantity" class="input input-bordered" min="1" value="1">
        </div>

        <div class="modal-action">
            <button class="btn btn-primary" onclick="tambahKeKeranjang()">Tambah</button>
            <button class="btn" onclick="modalPilihBarang.close()">Batal</button>
        </div>
    </div>
</dialog>

<!-- Modal Tambah Barang Baru -->
<dialog id="modalTambahBarang" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Tambah Barang Baru</h3>
        
        <form id="formTambahBarang">
            @csrf
            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Nama Barang</span>
                </label>
                <input type="text" name="nama" class="input input-bordered" required>
            </div>

            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Barcode</span> 
                </label>
                <input type="text" name="barcode" class="input input-bordered" required>
            </div>

            <div class="form-control mb-4">
                <label class="label">
                    <span class="label-text">Harga Jual</span>
                </label>
                <input type="number" name="harga_jual" class="input input-bordered" min="0" required>
            </div>

            <div class="modal-action">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn" onclick="modalTambahBarang.close()">Batal</button>
            </div>
        </form>
    </div>
</dialog>


<script>
let items = [];

function pilihBarang() {
    document.getElementById('modalPilihBarang').showModal();
}

function tambahBarangBaru() {
    document.getElementById('modalTambahBarang').showModal();
}

function tambahKeKeranjang() {
    const barangId = $('#selectBarang').val();
    const barangNama = $('#selectBarang option:selected').data('nama');
    const hargaBeli = parseFloat($('#inputHargaBeli').val());
    const quantity = parseInt($('#inputQuantity').val());

    if(!barangId || !hargaBeli || !quantity) {
        alert('Lengkapi semua data!');
        return;
    }

    // Cek apakah barang sudah ada
    const existingItem = items.find(item => item.barang_id === barangId);
    if(existingItem) {
        alert('Barang sudah ada di keranjang!');
        return;
    }

    items.push({
        barang_id: barangId,
        nama: barangNama,
        harga_beli: hargaBeli,
        quantity: quantity
    });

    updateTable();
    modalPilihBarang.close();
    
    // Reset form
    $('#selectBarang').val('');
    $('#inputHargaBeli').val('');
    $('#inputQuantity').val('1');
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
            const subtotal = item.quantity * item.harga_beli;
            tbody.append(`
                <tr>
                    <td>${item.nama}</td>
                    <td>Rp ${new Intl.NumberFormat('id-ID').format(item.harga_beli)}</td>
                    <td>${item.quantity}</td>
                    <td>Rp ${new Intl.NumberFormat('id-ID').format(subtotal)}</td>
                    <td>
                        <button type="button" onclick="hapusItem(${index})"
                            class="btn btn-error btn-sm">
                            <i class='bx bx-trash'></i>
                        </button>
                        <input type="hidden" name="items[${index}][barang_id]" value="${item.barang_id}">
                        <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                        <input type="hidden" name="items[${index}][harga_beli]" value="${item.harga_beli}">
                    </td>
                </tr>
            `);
        });
        $('#btnSimpan').prop('disabled', false);
    }

    updateTotal();
}

function hapusItem(index) {
    items.splice(index, 1);
    updateTable();
}

function updateTotal() {
    const total = items.reduce((acc, item) => acc + (item.harga_beli * item.quantity), 0);
    $('#totalPembelian').text(`Rp ${new Intl.NumberFormat('id-ID').format(total)}`);
}

// Handler untuk form tambah barang baru
document.querySelector('#formTambahBarang').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch("{{ route('pembelian.store-barang') }}", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            const barang = response.barang;

            const selectBarang = document.querySelector('#selectBarang');
            const option = document.createElement('option');
            option.value = barang.id;
            option.dataset.nama = barang.nama;
            option.textContent = barang.nama;
            selectBarang.appendChild(option);

            modalTambahBarang.close();

            // Reset form
            this.reset();

            // Tampilkan pesan sukses
            alert('Barang baru berhasil ditambahkan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan');
    });
});


// Validasi form sebelum submit
$('#formPembelian').on('submit', function(e) {
    if(items.length === 0) {
        e.preventDefault();
        alert('Tambahkan minimal 1 barang!');
        return false;
    }

    // Cek nomor nota dan supplier
    if(!$('input[name="nomor_nota"]').val() || !$('select[name="supplier_id"]').val()) {
        e.preventDefault();
        alert('Lengkapi nomor nota dan supplier!');
        return false;
    }

    return confirm('Apakah data sudah benar?');
});
</script>

@endsection