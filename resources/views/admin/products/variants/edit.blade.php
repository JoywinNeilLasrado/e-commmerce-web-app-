@extends('layouts.admin')

@section('title', 'Edit Variant - ' . $product->title)

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Edit Variant: {{ $variant->sku }}</h1>
            <a href="{{ route('admin.products.variants.index', $product) }}" class="text-sm text-gray-600 hover:text-gray-900">← Back to Variants</a>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.products.variants.update', [$product, $variant]) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Condition & SKU -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="condition_id" class="block text-sm font-medium text-gray-700">Condition</label>
                        <select id="condition_id" name="condition_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm rounded-md">
                            @foreach($conditions as $condition)
                                <option value="{{ $condition->id }}" {{ $variant->condition_id == $condition->id ? 'selected' : '' }}>
                                    {{ $condition->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('condition_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $variant->sku) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                        @error('sku')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Attributes -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="storage" class="block text-sm font-medium text-gray-700">Storage</label>
                        <select name="storage" id="storage" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm rounded-md">
                            @foreach(['64GB', '128GB', '256GB', '512GB', '1TB'] as $storage)
                                <option value="{{ $storage }}" {{ $variant->storage == $storage ? 'selected' : '' }}>{{ $storage }}</option>
                            @endforeach
                        </select>
                         @error('storage')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700">Color</label>
                        <input type="text" name="color" id="color" value="{{ old('color', $variant->color) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                        @error('color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Price & Stock -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price (₹)</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $variant->price) }}" required min="0" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-medium text-gray-700">Stock Quantity</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $variant->stock) }}" required min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                        @error('stock')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div class="flex items-center">
                    <input id="is_available" name="is_available" type="checkbox" value="1" {{ old('is_available', $variant->is_available) ? 'checked' : '' }} class="h-4 w-4 text-gray-900 focus:ring-gray-900 border-gray-300 rounded">
                    <label for="is_available" class="ml-2 block text-sm text-gray-900">
                        Available for Sale
                    </label>
                </div>

                <div class="pt-6 border-t border-gray-200">
                    <button type="submit" class="w-full bg-gray-900 border border-transparent rounded-lg shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                        Update Variant
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
