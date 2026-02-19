@extends('layouts.admin')

@section('title', 'Add New Product - Admin Dashboard')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Add New Product</h1>
            <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-600 hover:text-gray-900">← Back to Products</a>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf

                <!-- Brand & Model Selection -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">1. Select Brand</label>
                        <div class="grid grid-cols-4 sm:grid-cols-6 gap-3">
                            @foreach($brands as $brand)
                                <button type="button" 
                                        onclick="selectBrand('{{ $brand->id }}')"
                                        data-brand-btn="{{ $brand->id }}"
                                        class="brand-btn relative group aspect-square rounded-2xl border-2 border-gray-100 bg-white hover:border-gray-200 hover:bg-gray-50 transition-all p-3 flex flex-col items-center justify-center gap-2">
                                    <div class="w-full h-10 flex items-center justify-center overflow-hidden">
                                        <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" class="max-w-full max-h-full object-contain filter grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100">
                                    </div>
                                    <span class="text-[10px] font-bold truncate w-full text-center text-gray-400 group-hover:text-gray-600">{{ $brand->name }}</span>
                                </button>
                            @endforeach
                        </div>
                        <input type="hidden" name="brand_id" id="hidden_brand_id" value="">
                        @error('phone_model_id')
                            <p class="mt-2 text-xs text-red-600 font-bold">Please select a brand and model.</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone_model_id" class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">2. Select Phone Model</label>
                        <select id="phone_model_id" name="phone_model_id" required 
                                class="block w-full rounded-xl border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm py-3 px-4 font-medium transition-all">
                            <option value="">Select Brand Above First</option>
                            @foreach($brands as $brand)
                                <optgroup label="{{ $brand->name }}" data-brand="{{ $brand->id }}" hidden>
                                    @foreach($brand->phoneModels as $model)
                                        <option value="{{ $model->id }}" {{ old('phone_model_id') == $model->id ? 'selected' : '' }}>{{ $model->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Images -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="primary_image" class="block text-sm font-medium text-gray-700">Primary Image</label>
                        <input type="file" name="primary_image" id="primary_image" accept="image/*" required class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="mt-1 text-xs text-gray-500">Main image displayed in listings.</p>
                        @error('primary_image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="product_images" class="block text-sm font-medium text-gray-700">Gallery Images</label>
                        <input type="file" name="product_images[]" id="product_images" accept="image/*" multiple class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        <p class="mt-1 text-xs text-gray-500">Upload multiple images for the product detail page.</p>
                        @error('product_images.*')
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

                    <div>
                        <label for="original_price" class="block text-sm font-medium text-gray-700">Original Price (MRP) (₹)</label>
                        <input type="number" name="original_price" id="original_price" value="{{ old('original_price') }}" min="0" step="0.01" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-gray-900 focus:border-gray-900 sm:text-sm">
                        @error('original_price')
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
    function selectBrand(brandId) {
        // 1. Update Hidden Input
        document.getElementById('hidden_brand_id').value = brandId;

        // 2. Update UI (active state on buttons)
        document.querySelectorAll('.brand-btn').forEach(btn => {
            if (btn.dataset.brandBtn === brandId) {
                btn.classList.add('border-blue-600', 'bg-blue-50/10', 'shadow-md', 'ring-2', 'ring-blue-600/20');
                btn.classList.remove('border-gray-100', 'bg-white', 'hover:border-gray-200', 'hover:bg-gray-50');
                btn.querySelector('img').classList.remove('grayscale', 'opacity-70');
                btn.querySelector('span').classList.add('text-blue-700');
                btn.querySelector('span').classList.remove('text-gray-400');
                
                // Add Checkmark
                if (!btn.querySelector('.absolute')) {
                    const check = document.createElement('div');
                    check.className = 'absolute -top-2 -right-2 w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center border-2 border-white shadow-lg z-10';
                    check.innerHTML = '<svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>';
                    btn.appendChild(check);
                }
            } else {
                btn.classList.remove('border-blue-600', 'bg-blue-50/10', 'shadow-md', 'ring-2', 'ring-blue-600/20');
                btn.classList.add('border-gray-100', 'bg-white', 'hover:border-gray-200', 'hover:bg-gray-50');
                btn.querySelector('img').classList.add('grayscale', 'opacity-70');
                btn.querySelector('span').classList.remove('text-blue-700');
                btn.querySelector('span').classList.add('text-gray-400');
                
                // Remove Checkmark
                const check = btn.querySelector('.absolute');
                if (check) check.remove();
            }
        });

        // 3. Filter Models
        const modelSelect = document.getElementById('phone_model_id');
        const optgroups = modelSelect.querySelectorAll('optgroup');
        
        modelSelect.value = ''; // Reset selection

        optgroups.forEach(group => {
            if (group.dataset.brand === brandId) {
                group.hidden = false;
            } else {
                group.hidden = true;
            }
        });
    }

    // Auto-select brand if old input exists (e.g. after validation error)
    @if(old('brand_id'))
        window.addEventListener('load', () => selectBrand('{{ old('brand_id') }}'));
    @endif
</script>
@endsection
