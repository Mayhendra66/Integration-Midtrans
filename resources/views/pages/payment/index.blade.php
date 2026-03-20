@extends('layouts.app')

@section('content')
    <main class="ml-64 flex-1 p-8">

        <!-- Top bar -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Payment</h1>
                <p class="text-sm text-gray-500 mt-0.5">Create a new transaction</p>
            </div>
        </div>

        <!-- Flash messages -->
        @if (session('success'))
            <div
                class="mb-5 flex items-center gap-2 bg-green-50 border border-green-200 text-green-600 text-sm px-4 py-3 rounded-xl">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- LEFT: Form -->
            <div class="lg:col-span-2 space-y-5">

                <!-- Select Product -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-sm font-semibold text-gray-700 mb-5">Select Product</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Category <span class="text-red-500">*</span>
                            </label>

                            <select name="category_id" id="category_id"
                                onchange="filterProducts(this.value); updateCategory(this)"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition bg-white text-gray-700">

                                <option value="">-- Select Category --</option>

                                @foreach ($products->unique('category_id') as $product)
                                    <option value="{{ $product->category_id }}">
                                        {{ $product->category->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <!-- Product -->
                        <div>
                            <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Product <span class="text-red-500">*</span>
                            </label>
                            <select name="product_id" id="product_id" onchange="updatePrice(this)"
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition bg-white text-gray-700">

                                <option value="">-- Select Product --</option>

                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                        data-stock="{{ $product->qty }}" data-category="{{ $product->category_id }}">
                                        {{ $product->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                </div>

                <!-- Transaction Details -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-sm font-semibold text-gray-700 mb-5">Transaction Details</h2>

                    <form method="POST" id="posForm" class="space-y-4" onsubmit="return false;">
                        @csrf

                        <input type="hidden" name="product_id" id="hidden_product_id">
                        <input type="hidden" name="category_id" id="hidden_category_id">
                        <input type="hidden" id="hidden_unit_price" name="unit_price">
                        <input type="hidden" name="total_price" id="total_price">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            <!-- Qty Sell -->
                            <div>
                                <label for="qty" class="block text-sm font-medium text-gray-700 mb-1.5">
                                    Qty Sell <span class="text-red-500">*</span>
                                </label>
                                <input type="number" id="qty" name="qty" value="{{ old('qty', 1) }}"
                                    min="1" placeholder="1" oninput="calculateTotal()"
                                    class="w-full px-4 py-2.5 text-sm border {{ $errors->has('qty') ? 'border-red-400 focus:ring-red-100' : 'border-gray-200 focus:border-blue-400 focus:ring-blue-100' }} rounded-xl focus:outline-none focus:ring-2 transition" />
                                @error('qty')
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Unit Price -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Unit Price</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-gray-400">Rp</span>
                                    <input type="text" id="unit_price_display" readonly placeholder="0"
                                        class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-100 rounded-xl bg-gray-50 text-gray-500 cursor-not-allowed" />
                                </div>
                            </div>

                        </div>

                        <!-- Total Price -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Total Price</label>
                            <div class="relative">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-blue-500">Rp</span>
                                <input type="text" id="total_price_display" readonly placeholder="0"
                                    class="w-full pl-10 pr-4 py-3 text-sm font-semibold border border-blue-100 rounded-xl bg-blue-50 text-blue-700 cursor-not-allowed" />
                            </div>
                        </div>

                        <!-- Note -->
                        <div>
                            <label for="note" class="block text-sm font-medium text-gray-700 mb-1.5">
                                Note <span class="text-gray-400 font-normal">(optional)</span>
                            </label>
                            <textarea id="note" name="note" rows="2" placeholder="Additional notes..."
                                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition resize-none">{{ old('note') }}</textarea>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center gap-3 pt-2">
                            <button type="button" onclick="resetForm()"
                                class="flex-1 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                                Reset
                            </button>
                            <button type="submit" onclick="processPayment()"
                                class="flex-1 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                                Process Payment
                            </button>
                        </div>

                    </form>
                </div>

            </div>

            <!-- RIGHT: Summary -->
            <div class="space-y-5">

                <!-- Order Summary -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-sm font-semibold text-gray-700 mb-5">Order Summary</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Category</span>
                            <span class="font-medium text-gray-800" id="summary_category">—</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Product</span>
                            <span class="font-medium text-gray-800" id="summary_product">—</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Unit Price</span>
                            <span class="font-medium text-gray-800" id="summary_price">Rp 0</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Qty</span>
                            <span class="font-medium text-gray-800" id="summary_qty">0</span>
                        </div>
                        <div class="border-t border-gray-100 pt-3">
                            <div class="flex justify-between">
                                <span class="text-sm font-semibold text-gray-700">Total</span>
                                <span class="text-base font-bold text-blue-600" id="summary_total">Rp 0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stock Info -->
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="text-sm font-semibold text-gray-700 mb-4">Stock Info</h2>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#2563eb"
                                stroke-width="2">
                                <path
                                    d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Available Stock</p>
                            <p class="text-2xl font-bold text-gray-800" id="summary_stock">—</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </main>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>


    <script>
        function processPayment() {
            const productId = document.getElementById('hidden_product_id').value;
            const categoryId = document.getElementById('hidden_category_id').value;
            const unitPrice = document.getElementById('hidden_unit_price').value; // ← raw number
            const qty = document.getElementById('qty').value;
            const totalPrice = document.getElementById('total_price').value;
            const note = document.getElementById('note').value;

            console.log('Data:', {
                productId,
                categoryId,
                unitPrice,
                qty,
                totalPrice
            });

            if (!productId || !categoryId || !unitPrice || !qty || !totalPrice) {
                alert('Please fill in all required fields.');
                return;
            }

            fetch('{{ route('payment.snap-token') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        category_id: categoryId,
                        qty: parseInt(qty),
                        total_price: parseInt(totalPrice),
                        unit_price: parseInt(unitPrice),
                        note: note,
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log('Server response:', data);

                    if (data.error) {
                        alert('Error: ' + data.message);
                        return;
                    }

                    if (!data.snap_token) {
                        alert('Failed to get payment token.');
                        return;
                    }

                    snap.pay(data.snap_token, {
                        onSuccess: function(result) {
                            console.log('onSuccess fired:', result); // ← add this
                            updateTransactionStatus(data.transaction_id, 'success');
                        },
                        onPending: function(result) {
                            console.log('onPending fired:', result);
                            console.log('transaction_id:', data.transaction_id); // ← add this
                            alert('transaction_id: ' + data.transaction_id);
                            updateTransactionStatus(data.transaction_id, 'success'); // ← treat as success
                        },
                        onError: function(result) {
                            console.log('onError fired:', result); // ← add this
                            updateTransactionStatus(data.transaction_id, 'failed');
                        },
                        onClose: function() {
                            console.log('onClose fired'); // ← add this
                            alert('Payment popup closed.');
                        }
                    });
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                    alert('Something went wrong: ' + err.message);
                });
        }

        function updateTransactionStatus(transactionId, status) {
            fetch('{{ route('payment.update-status') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        transaction_id: transactionId,
                        status: status
                    })
                })
                .then(res => res.json()) // ← add this
                .then(data => {
                    console.log('Update status response:', data); // ← add this
                    if (status === 'success') {
                        alert('Payment successful! Transaction saved.');
                        resetForm();
                    } else if (status === 'failed') {
                        alert('Payment failed.');
                    }
                })
                .catch(err => {
                    console.error('Update status error:', err);
                });
        }

        function filterProducts(categoryId) {
            const productSelect = document.getElementById('product_id');
            const options = productSelect.querySelectorAll('option');

            options.forEach(option => {
                if (option.value === "") {
                    option.hidden = false;
                    return;
                }
                const productCategory = option.dataset.category;
                option.hidden = productCategory != categoryId;
            });

            productSelect.value = "";

            // ← reset product related fields when category changes
            document.getElementById('hidden_product_id').value = '';
            document.getElementById('hidden_unit_price').value = '';
            document.getElementById('unit_price_display').value = '';
            document.getElementById('total_price').value = 0;
            document.getElementById('total_price_display').value = '';
            document.getElementById('summary_product').textContent = '—';
            document.getElementById('summary_stock').textContent = '—';
            document.getElementById('summary_price').textContent = 'Rp 0';
            document.getElementById('summary_qty').textContent = '0';
            document.getElementById('summary_total').textContent = 'Rp 0';
        }

        function formatRupiah(number) {
            return Number(number).toLocaleString('id-ID');
        }

        function updatePrice(select) {
            const opt = select.options[select.selectedIndex];
            const price = opt?.dataset.price ?? 0; // ← raw number
            const stock = opt?.dataset.stock ?? '—';
            const name = opt?.text ?? '—';

            document.getElementById('hidden_product_id').value = select.value;
            document.getElementById('hidden_unit_price').value = price; // ← store raw price here
            document.getElementById('unit_price_display').value = select.value ? formatRupiah(price) : '';
            document.getElementById('summary_product').textContent = select.value ? name : '—';
            document.getElementById('summary_stock').textContent = select.value ? stock : '—';
            document.getElementById('summary_price').textContent = select.value ? 'Rp ' + formatRupiah(price) : 'Rp 0';

            calculateTotal();
        }

        function updateCategory(select) {
            const selectedText = select.options[select.selectedIndex].text;

            document.getElementById('summary_category').textContent =
                select.value ? selectedText : '—';

            document.getElementById('hidden_category_id').value = select.value; // ← set hidden category
        }

        function calculateTotal() {
            const unitPrice = document.getElementById('hidden_unit_price').value; // ← use raw price
            const qty = parseInt(document.getElementById('qty').value) || 0;
            const price = parseFloat(unitPrice) || 0;
            const total = qty * price;

            document.getElementById('total_price').value = total;
            document.getElementById('total_price_display').value = total ? formatRupiah(total) : '';
            document.getElementById('summary_qty').textContent = qty;
            document.getElementById('summary_total').textContent = 'Rp ' + formatRupiah(total);
        }

        function resetSummaryProduct() {
            document.getElementById('unit_price_display').value = '';
            document.getElementById('total_price_display').value = '';
            document.getElementById('total_price').value = 0;
            document.getElementById('hidden_unit_price').value = ''; // ← clear raw price
            document.getElementById('summary_product').textContent = '—';
            document.getElementById('summary_stock').textContent = '—';
            document.getElementById('summary_price').textContent = 'Rp 0';
            document.getElementById('summary_qty').textContent = '0';
            document.getElementById('summary_total').textContent = 'Rp 0';
        }

        function resetForm() {
            document.getElementById('posForm').reset();
            document.getElementById('category_id').value = '';
            document.getElementById('product_id').value = '';
            document.getElementById('hidden_category_id').value = '';
            document.getElementById('hidden_product_id').value = '';
            document.getElementById('hidden_unit_price').value = ''; // ← clear raw price
            document.getElementById('unit_price_display').value = '';
            document.getElementById('total_price_display').value = '';
            document.getElementById('total_price').value = 0;
            document.getElementById('summary_category').textContent = '—';
            resetSummaryProduct();
        }
    </script>
@endsection
