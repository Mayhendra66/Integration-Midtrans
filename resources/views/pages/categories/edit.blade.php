@extends('layouts.app')

@section('content')

    <main class="ml-64 flex-1 p-8">

        <div class="max-w-xl mx-auto mt-10">

            <!-- Header -->
            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('categories') }}"
                    class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 hover:bg-gray-50 transition text-gray-500">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="15 18 9 12 15 6" />
                    </svg>
                </a>

                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Edit Category</h1>
                    <p class="text-sm text-gray-500 mt-0.5">
                        Update "{{ e($category->name) }}"
                    </p>
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

                <form method="POST" action="{{ route('categories.update', ['id' => $category->id]) }}" class="space-y-5">

                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Name <span class="text-red-500">*</span>
                        </label>

                        <input type="text" id="name" name="name" required
                            value="{{ old('name', $category->name) }}" placeholder="e.g. Electronics"
                            class="w-full px-4 py-2.5 text-sm border
          {{ $errors->has('name') ? 'border-red-400 focus:ring-red-100 focus:border-red-400' : 'border-gray-200 focus:border-blue-400 focus:ring-blue-100' }}
          rounded-xl focus:outline-none focus:ring-2 transition">

                        @error('name')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Description
                        </label>

                        <textarea id="description" name="description" rows="3" placeholder="Short description of this category..."
                            class="w-full px-4 py-2.5 text-sm border
          {{ $errors->has('description') ? 'border-red-400 focus:ring-red-100 focus:border-red-400' : 'border-gray-200 focus:border-blue-400 focus:ring-blue-100' }}
          rounded-xl focus:outline-none focus:ring-2 transition resize-none">{{ old('description', $category->description) }}</textarea>

                        @error('description')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>


                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>

                        <div class="flex items-center justify-between px-4 py-3 border border-gray-200 rounded-xl">

                            <div>
                                <p class="text-sm font-medium text-gray-700">Active</p>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    Category will be visible to users
                                </p>
                            </div>

                            <label class="relative inline-flex items-center cursor-pointer">

                                <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                                    {{ old('is_active', $category->is_active) ? 'checked' : '' }}>

                                <div class="w-11 h-6 bg-gray-200 rounded-full peer-checked:bg-blue-500 transition"></div>

                                <div
                                    class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition peer-checked:translate-x-5">
                                </div>

                            </label>

                        </div>
                    </div>


                    <!-- Meta info -->
                    <div class="flex items-center gap-6 px-4 py-3 bg-gray-50 rounded-xl text-xs text-gray-400">

                        <div>
                            <span class="font-medium text-gray-500">Created</span>
                            <span class="ml-1.5">{{ optional($category->created_at)->format('d M Y, H:i') }}</span>
                        </div>

                        <div>
                            <span class="font-medium text-gray-500">Last updated</span>
                            <span
                                class="ml-1.5">{{ optional($category->updated_at)->format('d M Y, H:i') ?? 'Belum Ter Update' }}</span>
                        </div>

                    </div>


                    <!-- Actions -->
                    <div class="flex items-center gap-3 pt-2">

                        <a href="{{ route('categories') }}"
                            class="flex-1 text-center py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 transition">
                            Cancel
                        </a>

                        <button type="submit"
                            class="flex-1 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold transition">
                            Save Changes
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </main>

@endsection
