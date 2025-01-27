@extends('../layout/app')

@section('page-title', 'Penjualan')
@section('content')
<div class="container mx-auto p-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Form Input Panel -->
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-xl font-bold mb-4">Input Penjualan</h2>
            
            <!-- Customer Search -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Customer</label>
                <select id="customer" class="w-full rounded border-gray-300" required>
                    <option value="">Cari customer...</option>
                </select>
            </div>

            <!-- Sales Search -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Sales</label>
                <select id="sales" class="w-full rounded border-gray-300" required>
                    <option value="">Cari sales...</option>
                </select>
            </div>

            <!-- Product Search -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Produk</label>
                <select id="product" class="w-full rounded border-gray-300">
                    <option value="">Cari produk...</option>
                </select>
            </div>

            <!-- Quantity Input -->
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Quantity</label>
                <div class="flex gap-2">
                    <input type="number" id="quantity" class="w-full rounded border-gray-300" min="1" value="1">
                    <button onclick="addToCart()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Tambah
                    </button>
                </div>
            </div>
        </div>

        <!-- Cart Panel -->
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-xl font-bold mb-4">Keranjang Belanja</h2>
            
            <!-- Cart Items -->
            <div class="mb-4 max-h-64 overflow-y-auto">
                <table class="w-full">
                    <thead class="border-b">
                        <tr>
                            <th class="text-left p-2">Produk</th>
                            <th class="text-right p-2">Qty</th>
                            <th class="text-right p-2">Harga</th>
                            <th class="text-right p-2">Subtotal</th>
                            <th class="p-2"></th>
                        </tr>
                    </thead>
                    <tbody id="cartItems">
                        <!-- Cart items will be inserted here -->
                    </tbody>
                </table>
            </div>

            <!-- Cart Summary -->
            <div class="border-t pt-4">
                <div class="flex justify-between mb-2">
                    <span>Subtotal:</span>
                    <span id="subtotal">Rp 0</span>
                </div>
                <div class="flex justify-between mb-4">
                    <span>Total:</span>
                    <span id="total" class="font-bold">Rp 0</span>
                </div>

                <!-- Payment Method -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Metode Pembayaran</label>
                    <select id="paymentMethod" class="w-full rounded border-gray-300" onchange="togglePaymentFields()">
                        <option value="cash">Cash</option>
                        <option value="credit">Kredit</option>
                    </select>
                </div>

                <!-- Credit Terms (hidden by default) -->
                <div id="creditTerms" class="mb-4 hidden">
                    <label class="block text-sm font-medium mb-1">Jatuh Tempo (hari)</label>
                    <input type="number" id="dueDate" class="w-full rounded border-gray-300" min="1" value="30">
                </div>

                <!-- Submit Button -->
                <button onclick="saveTransaction()" class="w-full px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Simpan Transaksi
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Initialize Select2 for searchable dropdowns
$(document).ready(function() {
    $('#customer').select2({
        ajax: {
            url: '/api/customers/search',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data.map(item => ({
                        id: item.id,
                        text: item.name
                    }))
                };
            }
        }
    });

    $('#sales').select2({
        ajax: {
            url: '/api/sales/search',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data.map(item => ({
                        id: item.id,
                        text: item.name
                    }))
                };
            }
        }
    });

    $('#product').select2({
        ajax: {
            url: '/api/products/search',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data.map(item => ({
                        id: item.id,
                        text: item.name,
                        price: item.price
                    }))
                };
            }
        }
    });
});

let cart = [];

function addToCart() {
    const product = $('#product').select2('data')[0];
    const quantity = parseInt($('#quantity').val());
    
    if (!product || quantity < 1) {
        alert('Pilih produk dan quantity yang valid');
        return;
    }

    const existingItem = cart.find(item => item.id === product.id);
    if (existingItem) {
        existingItem.quantity += quantity;
    } else {
        cart.push({
            id: product.id,
            name: product.text,
            price: product.price,
            quantity: quantity
        });
    }

    updateCartDisplay();
    resetProductInput();
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateCartDisplay();
}

function updateCartDisplay() {
    const tbody = document.getElementById('cartItems');
    tbody.innerHTML = '';

    let subtotal = 0;

    cart.forEach((item, index) => {
        const row = document.createElement('tr');
        const itemSubtotal = item.price * item.quantity;
        subtotal += itemSubtotal;

        row.innerHTML = `
            <td class="p-2">${item.name}</td>
            <td class="text-right p-2">${item.quantity}</td>
            <td class="text-right p-2">Rp ${item.price.toLocaleString()}</td>
            <td class="text-right p-2">Rp ${itemSubtotal.toLocaleString()}</td>
            <td class="p-2">
                <button onclick="removeFromCart(${index})" class="text-red-500 hover:text-red-700">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        tbody.appendChild(row);
    });

    document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString()}`;
    document.getElementById('total').textContent = `Rp ${subtotal.toLocaleString()}`;
}

function togglePaymentFields() {
    const creditTerms = document.getElementById('creditTerms');
    creditTerms.style.display = 
        document.getElementById('paymentMethod').value === 'credit' ? 'block' : 'none';
}

function resetProductInput() {
    $('#product').val(null).trigger('change');
    $('#quantity').val(1);
}

function saveTransaction() {
    if (cart.length === 0) {
        alert('Keranjang belanja masih kosong');
        return;
    }

    const customerId = $('#customer').val();
    const salesId = $('#sales').val();
    const paymentMethod = $('#paymentMethod').val();
    const dueDate = paymentMethod === 'credit' ? $('#dueDate').val() : null;

    if (!customerId || !salesId) {
        alert('Pilih customer dan sales terlebih dahulu');
        return;
    }

    const transaction = {
        customer_id: customerId,
        sales_id: salesId,
        payment_method: paymentMethod,
        due_date: dueDate,
        items: cart
    };

    // Send to server
    fetch('/api/transactions', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(transaction)
    })
    .then(response => response.json())
    .then(data => {
        alert('Transaksi berhasil disimpan!');
        // Reset form
        cart = [];
        updateCartDisplay();
        $('#customer').val(null).trigger('change');
        $('#sales').val(null).trigger('change');
        $('#paymentMethod').val('cash').trigger('change');
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan transaksi');
    });
}
</script>
@endpush

@endsection