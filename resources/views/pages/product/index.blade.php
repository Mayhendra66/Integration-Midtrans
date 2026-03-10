@extends('layouts.app')

@section('content')

    <main class="ml-64 flex-1 p-8">

        <!-- Top bar -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Products</h1>
                <p class="text-sm text-gray-500 mt-0.5">Manage your Product</p>
            </div>
            <a href="{{ route('products.create') }}"
                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                New Product
            </a>
        </div>

        <!-- Flash messages -->
        @if (session('success'))
            <div
                class="mb-5 flex items-center gap-2 bg-green-50 border border-green-200 text-green-600 text-sm px-4 py-3 rounded-xl">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Card -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">

            <!-- Search & Count -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" width="15" height="15"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <input type="text" id="searchInput" placeholder="Search Product..." oninput="filterTable()"
                        class="pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition w-64" />
                </div>
                <span class="text-xs text-gray-400 font-medium">{{ $products->count() }}
                    {{ Str::plural('product', $products->count()) }}</span>
            </div>

            <!-- Two-column layout -->
            <div class="p-6">
                @if ($products->isEmpty())

                    <!-- Empty state -->
                    <div class="text-center py-16">
                        <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#9ca3af"
                                stroke-width="1.5">
                                <path d="M4 6h16M4 12h16M4 18h7" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500">No products yet</p>
                        <p class="text-xs text-gray-400 mt-1">Click "New product" to get started</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-5">

                        {{-- Column 1: items 1–8 --}}
                        @if ($products->isNotEmpty())
                            <div class="rounded-xl border border-gray-100 overflow-hidden">
                                <table class="w-full text-sm" id="table1">
                                    <thead>
                                        <tr class="bg-gray-50 text-xs text-gray-400 font-semibold uppercase tracking-wide">
                                            <th class="px-4 py-3 text-left">Categories</th>
                                            <th class="px-4 py-3 text-left">Name</th>
                                            <th class="px-4 py-3 text-left">Quantity</th>
                                            <th class="px-4 py-3 text-left">Price</th>
                                            <th class="px-4 py-3 text-center">Status</th>
                                            <th class="px-4 py-3 text-left">Created At</th>
                                            <th class="px-4 py-3 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-50">

                                        @foreach ($products as $product)
                                            <tr class="hover:bg-gray-50 transition table-row"
                                                data-name="{{ strtolower($product->name) }}"
                                                data-desc="{{ strtolower($product->description ?? '') }}">

                                                <!-- Category -->
                                                <td class="px-4 py-3 font-medium text-gray-800 whitespace-nowrap">
                                                    {{ $product->category->name ?? '—' }}
                                                </td>

                                                <!-- Product Name -->
                                                <td class="px-4 py-3 font-medium text-gray-800 whitespace-nowrap">
                                                    {{ $product->name }}
                                                </td>

                                                <!-- Qty -->
                                                <td class="px-4 py-3 text-gray-500 max-w-[140px] truncate"
                                                    title="{{ $product->qty }}">
                                                    {{ $product->qty ?? '—' }}
                                                </td>

                                                <td class="px-4 py-3 text-gray-500 max-w-[140px] truncate"
                                                    title="Rp {{ number_format($product->price, 0, ',', '.') }}">
                                                    Rp {{ number_format($product->price, 0, ',', '.') ?? '—' }}
                                                </td>

                                                <!-- Status -->
                                                <td class="px-4 py-3 text-center">
                                                    @if ($product->is_active)
                                                        <span
                                                            class="inline-block text-xs bg-green-50 text-green-600 px-2.5 py-0.5 rounded-full font-medium">
                                                            Active
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-block text-xs bg-gray-100 text-gray-400 px-2.5 py-0.5 rounded-full font-medium">
                                                            Inactive
                                                        </span>
                                                    @endif
                                                </td>

                                                <!-- Created At -->
                                                <td class="px-4 py-3 text-gray-400 text-xs whitespace-nowrap">
                                                    {{ $product->created_at?->format('d M Y') ?? '-' }}
                                                </td>

                                                <!-- Actions -->
                                                <td class="px-4 py-3">
                                                    <div class="flex items-center justify-center gap-1.5">

                                                        <!-- Edit -->
                                                        <a href="{{ route('products.edit', ['id' => $product->id]) }}"
                                                            class="w-7 h-7 flex items-center justify-center rounded-lg text-blue-500 hover:bg-blue-50 transition"
                                                            title="Edit">

                                                            <svg width="14" height="14" viewBox="0 0 24 24"
                                                                fill="none" stroke="currentColor" stroke-width="2">
                                                                <path
                                                                    d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7" />
                                                                <path
                                                                    d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                                                            </svg>

                                                        </a>

                                                        <!-- Delete -->
                                                        <form method="POST"
                                                            action="{{ route('products.destroy', ['id' => $product->id]) }}"
                                                            onsubmit="return confirm('Delete {{ $product->name }}?')">

                                                            @csrf

                                                            <button type="submit"
                                                                class="w-7 h-7 flex items-center justify-center rounded-lg text-red-400 hover:bg-red-50 transition"
                                                                title="Delete">

                                                                <svg width="14" height="14" viewBox="0 0 24 24"
                                                                    fill="none" stroke="currentColor"
                                                                    stroke-width="2">
                                                                    <polyline points="3 6 5 6 21 6" />
                                                                    <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6" />
                                                                    <path d="M10 11v6M14 11v6" />
                                                                    <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2" />
                                                                </svg>

                                                            </button>

                                                        </form>

                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        @endif


                    </div>

                    <!-- No search results (hidden by default, shown by JS) -->
                    <div id="emptySearch" class="hidden text-center py-16">
                        <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#9ca3af"
                                stroke-width="1.5">
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-gray-500">No categories found</p>
                        <p class="text-xs text-gray-400 mt-1">Try a different search keyword</p>
                    </div>

                @endif
            </div>

        </div>

    </main>

@endsection

@push('scripts')
    <script>
        function filterTable() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('.table-row');
            let visible = 0;

            rows.forEach(row => {
                const name = row.dataset.name ?? '';
                const desc = row.dataset.desc ?? '';
                const match = name.includes(q) || desc.includes(q);
                row.style.display = match ? '' : 'none';
                if (match) visible++;
            });

            const emptySearch = document.getElementById('emptySearch');
            if (emptySearch) {
                emptySearch.classList.toggle('hidden', visible > 0);
            }
        }
    </script>
@endpush
