@extends('layouts.app')

@section('title', 'Add New Product - Admin Dashboard')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Add New Product</h1>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-600 hover:text-gray-900">← Back to Products</a>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.products.store') }}" method="POST" class="p-6 space-y-6">
                @csrf

                <!-- Brand & Model -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="brand_id" class="block text-sm font-medium text-gray-700">Brand</label>
                        <select id="brand_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm rounded-md">
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="phone_model_id" class="block text-sm font-medium text-gray-700">Phone Model</label>
                        <select id="phone_model_id" name="phone_model_id" required class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm rounded-md">
                            <option value="">Select Brand First</option>
                            @foreach($brands as $brand)
                                <optgroup label="{{ $brand->name }}" data-brand="{{ $brand->id }}" hidden>
                                    @foreach($brand->phoneModels as $model)
                                        <option value="{{ $model->id }}">{{ $model->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                         @error('phone_model_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Title & Price -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Product Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. iPhone 13 Pro (Refurbished)" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="base_price" class="block text-sm font-medium text-gray-700">Base Price (₹)</label>
                        <input type="number" name="base_price" id="base_price" value="{{ old('base_price') }}" required min="0" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                        @error('base_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-900 focus:border-gray-900 sm:text-sm">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Technical Details -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="warranty_months" class="block text-sm font-medium text-gray-700">Warranty (Months)</label>
                        <input type="number" name="warranty_months" id="warranty_months" value="{{ old('warranty_months', 6) }}" required min="0" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                         @error('warranty_months')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                         <label for="whats_in_box" class="block text-sm font-medium text-gray-700">What's in the box</label>
                         <input type="text" name="whats_in_box" id="whats_in_box" value="{{ old('whats_in_box', 'Phone, Charging Cable') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                    </div>
                </div>

                <!-- Status -->
                <div class="flex items-center space-x-6">
                    <div class="flex items-center">
                        <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="h-4 w-4 text-gray-900 focus:ring-gray-900 border-gray-300 rounded">
                        <label for="is_active" class="ml-2 block text-sm text-gray-900">
                            Active (Visible)
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input id="is_featured" name="is_featured" type="checkbox" value="1" {{ old('is_featured') ? 'checked' : '' }} class="h-4 w-4 text-gray-900 focus:ring-gray-900 border-gray-300 rounded">
                        <label for="is_featured" class="ml-2 block text-sm text-gray-900">
                            Featured Product
                        </label>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-200">
                    <button type="submit" class="w-full bg-gray-900 border border-transparent rounded-lg shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                        Create Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Simple script to filter models by brand
    document.getElementById('brand_id').addEventListener('change', function() {
        const brandId = this.value;
        const modelSelect = document.getElementById('phone_model_id');
        const optgroups = modelSelect.querySelectorAll('optgroup');
        
        modelSelect.value = ''; // Reset selection

        if (!brandId) {
            optgroups.forEach(group => group.hidden = true);
            return;
        }

        optgroups.forEach(group => {
            if (group.dataset.brand === brandId) {
                group.hidden = false;
            } else {
                group.hidden = true;
            }
        });
    });
</script>
@endsection
