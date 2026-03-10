@extends('layouts.app')

@section('content')
    <main class="ml-64 flex-1 p-8">

        <!-- Top bar -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
                <p class="text-sm text-gray-500 mt-0.5">Welcome back, <span
                        class="font-medium text-gray-700">{{ auth()->user()->name }}</span> 👋</p>
            </div>
            <div class="flex items-center gap-2 bg-white border border-gray-100 rounded-xl px-4 py-2 shadow-sm">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#6b7280" stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M12 6v6l4 2" />
                </svg>
                <span class="text-sm text-gray-500" id="datetime"></span>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Revenue</span>
                    <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#2563eb"
                            stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23" />
                            <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-800">Rp 48.2M</p>
                <p class="text-xs text-green-500 mt-1 font-medium">↑ 12.5% this month</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Categories Active</span>
                    <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#7c3aed"
                            stroke-width="2">
                            <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" />
                            <line x1="3" y1="6" x2="21" y2="6" />
                            <path d="M16 10a4 4 0 01-8 0" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-800">{{ $activeCategories }}</p>
                <p class="text-xs text-gray-400 mt-1 font-medium">From {{ $totalCategories }} Categories</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Products Active</span>
                    <div class="w-9 h-9 bg-orange-50 rounded-xl flex items-center justify-center">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ea580c"
                            stroke-width="2">
                            <path
                                d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" />
                        </svg>
                    </div>
                </div>
<p class="text-2xl font-bold text-gray-800">
    {{ $activeProducts }}
</p>

<p class="text-xs text-gray-400 mt-1 font-medium">
    From {{ $totalProducts }} Products
</p>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Payments</span>
                    <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a"
                            stroke-width="2">
                            <rect x="2" y="5" width="20" height="14" rx="2" />
                            <path d="M2 10h20" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-800">98.4%</p>
                <p class="text-xs text-green-500 mt-1 font-medium">Success rate</p>
            </div>

        </div>

        <!-- Bottom grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

            <!-- Recent Transactions -->
            <div class="lg:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
                    <h2 class="text-sm font-semibold text-gray-800">Recent Transactions</h2>
                    <a href="/payments" class="text-xs text-blue-600 hover:text-blue-700 font-medium">View all</a>
                </div>
                <div class="divide-y divide-gray-50">

                    <div class="flex items-center gap-4 px-6 py-4">
                        <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center shrink-0">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#16a34a"
                                stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800">Order #INV-00482</p>
                            <p class="text-xs text-gray-400">Bank Transfer · BCA</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-800">Rp 320,000</p>
                            <span
                                class="inline-block text-xs bg-green-50 text-green-600 px-2 py-0.5 rounded-full font-medium">Paid</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 px-6 py-4">
                        <div class="w-9 h-9 bg-yellow-50 rounded-xl flex items-center justify-center shrink-0">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#ca8a04"
                                stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800">Order #INV-00481</p>
                            <p class="text-xs text-gray-400">GoPay · E-Wallet</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-800">Rp 155,000</p>
                            <span
                                class="inline-block text-xs bg-yellow-50 text-yellow-600 px-2 py-0.5 rounded-full font-medium">Pending</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 px-6 py-4">
                        <div class="w-9 h-9 bg-green-50 rounded-xl flex items-center justify-center shrink-0">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#16a34a"
                                stroke-width="2">
                                <polyline points="20 6 9 17 4 12" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800">Order #INV-00480</p>
                            <p class="text-xs text-gray-400">Credit Card · Visa</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-800">Rp 890,000</p>
                            <span
                                class="inline-block text-xs bg-green-50 text-green-600 px-2 py-0.5 rounded-full font-medium">Paid</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 px-6 py-4">
                        <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center shrink-0">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#dc2626"
                                stroke-width="2">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-800">Order #INV-00479</p>
                            <p class="text-xs text-gray-400">OVO · E-Wallet</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-semibold text-gray-800">Rp 210,000</p>
                            <span
                                class="inline-block text-xs bg-red-50 text-red-500 px-2 py-0.5 rounded-full font-medium">Failed</span>
                        </div>
                    </div>

                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50">
                    <h2 class="text-sm font-semibold text-gray-800">Top Categories</h2>
                    <a href="{{ route('categories') }}" class="text-xs text-blue-600 hover:text-blue-700 font-medium">
                        View all
                    </a>
                </div>

                <div class="px-6 py-4 space-y-4">
                    @php
                        $colors = ['bg-blue-500', 'bg-purple-500', 'bg-orange-400', 'bg-green-500', 'bg-pink-400'];
                    @endphp
                    @foreach ($topCategories as $index => $category)
                        <div>
                            <div class="flex justify-between text-xs mb-1.5">
                                <span class="font-medium text-gray-700">
                                    {{ $category->name }}
                                </span>
                                <span class="text-gray-400">
                                    {{ $category->percent }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5">
                                <div class="{{ $colors[$index % count($colors)] }} h-1.5 rounded-full"
                                    style="width: {{ $category->percent }}%">
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>

            </div>

    </main>
@endsection
