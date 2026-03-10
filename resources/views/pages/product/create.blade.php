@extends('layouts.app')

@section('content')

    <main class="ml-64 flex-1 p-8">

        <div class="max-w-xl mx-auto mt-10">

            <!-- Header -->
            <div class="flex items-center gap-4 mb-8">

                <a href="{{ route('products') }}"
                    class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 hover:bg-gray-50 transition text-gray-500">

                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6" />
                    </svg>

                </a>

                <div>
                    <h1 class="text-2xl font-bold text-gray-800">New Product</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Add a new product</p>
                </div>

            </div>


            <!-- Validation errors -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 text-sm px-4 py-3 rounded-xl">

                    <p class="font-semibold mb-1">Please fix the following errors:</p>

                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif


            <!-- Form -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">

                <form method="POST" action="{{ route('products.store') }}" class="space-y-5">
                    @csrf

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Category <span class="text-red-500">*</span>
                        </label>

                        <select name="category_id"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition">

                            <option value="">Select Category</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>

                                    {{ $category->name }}

                                </option>
                            @endforeach

                        </select>
                    </div>


                    <!-- Product Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Product Name <span class="text-red-500">*</span>
                        </label>

                        <input type="text" name="name" value="{{ old('name') }}"
                            placeholder="e.g. Ocean Mist Perfume"
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition">
                    </div>


                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            Description
                        </label>

                        <textarea name="description" rows="3" placeholder="Short description of this product..."
                            class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100 transition resize-none">{{ old('description') }}</textarea>
                    </div>


                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>

                        <div class="flex items-center justify-between px-4 py-3 border border-gray-200 rounded-xl">

                            <div>
                                <p class="text-sm font-medium text-gray-700">Active</p>
                                <p class="text-xs text-gray-400 mt-0.5">Product will be visible to users</p>
                            </div>

                            <label class="relative inline-flex items-center cursor-pointer">

                                <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                                    {{ old('is_active', true) ? 'checked' : '' }}>

                                <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-blue-500 transition"></div>
                                <div
                                    class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition peer-checked:translate-x-5">
                                </div>

                            </label>

                        </div>
                    </div>


                    <!-- Buttons -->
                    <div class="flex items-center gap-3 pt-2">

                        <a href="{{ route('products') }}"
                            class="flex-1 text-center py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                            Cancel
                        </a>

                        <button type="submit"
                            class="flex-1 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                            Create Product
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </main>

@endsection
