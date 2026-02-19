@extends('layouts.admin')

@section('title', 'Edit Product - Admin Dashboard')

@section('content')
<div class="bg-gray-50 min-h-screen pb-12">
    
    <!-- Sticky Header -->
    <div class="sticky top-0 z-30 bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <h1 class="text-lg font-bold text-gray-900 truncate">Edit: {{ $product->title }}</h1>
            <span class="text-xs px-2 py-0.5 rounded bg-blue-50 text-blue-700 font-mono border border-blue-100">{{ $product->phoneModel->name }}</span>
        </div>
        <div class="flex items-center gap-2">
             <a href="{{ route('admin.products.variants.index', $product) }}" class="text-xs font-medium text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-lg transition-colors flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                Variants
            </a>
            <button type="submit" form="product-form" class="bg-gray-900 text-white text-xs font-medium px-5 py-2 rounded-lg hover:bg-gray-800 transition-colors shadow-sm flex items-center gap-2">
                Save
            </button>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <form id="product-form" action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- Left Column: Identity (col-span-4) -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">Product Identity</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Title</label>
                                <input type="text" name="title" value="{{ old('title', $product->title) }}" required 
                                       class="block w-full rounded-md border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900 shadow-sm py-1.5">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Brand</label>
                                    <select id="brand_id" class="block w-full rounded-md border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900 shadow-sm py-1.5">
                                        <option value="">Select</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ $product->phoneModel->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Model</label>
                                    <select id="phone_model_id" name="phone_model_id" required class="block w-full rounded-md border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900 shadow-sm py-1.5">
                                        <option value="">Select Brand</option>
                                        @foreach($brands as $brand)
                                            <optgroup label="{{ $brand->name }}" data-brand="{{ $brand->id }}" {{ $product->phoneModel->brand_id == $brand->id ? '' : 'hidden' }}>
                                                @foreach($brand->phoneModels as $model)
                                                    <option value="{{ $model->id }}" {{ $product->phone_model_id == $model->id ? 'selected' : '' }}>{{ $model->name }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Base Price</label>
                                <div class="relative rounded-md shadow-sm">
                                    <span class="absolute left-3 top-1.5 text-gray-400 text-sm">₹</span>
                                    <input type="number" name="base_price" value="{{ old('base_price', $product->base_price) }}" required min="0" step="0.01"
                                           class="block w-full rounded-md border-gray-300 pl-7 text-sm font-bold text-gray-900 focus:ring-gray-900 focus:border-gray-900 py-1.5">
                                </div>
                            </div>

                            <div class="pt-3 flex gap-4">
                                <label class="inline-flex items-center cursor-pointer group">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="rounded border-gray-300 text-gray-900 shadow-sm focus:border-gray-300 focus:ring focus:ring-offset-0 focus:ring-gray-200 focus:ring-opacity-50 h-4 w-4 cursor-pointer">
                                    <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-900 select-none">Active</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer group">
                                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="rounded border-gray-300 text-gray-900 shadow-sm focus:border-gray-300 focus:ring focus:ring-offset-0 focus:ring-gray-200 focus:ring-opacity-50 h-4 w-4 cursor-pointer">
                                    <span class="ml-2 text-sm text-gray-600 group-hover:text-gray-900 select-none">Featured</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Middle Column: Images (col-span-4) -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">Visuals</h2>
                        
                        <!-- Main Preview -->
                        <div class="h-48 w-full bg-gray-50 rounded-lg border border-gray-200 relative group overflow-hidden mb-4 flex items-center justify-center">
                            @if($product->primary_image)
                                <img src="{{ Str::startsWith($product->primary_image, 'http') ? $product->primary_image : asset('storage/' . $product->primary_image) }}" class="max-w-full max-h-full object-contain p-2">
                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 to-transparent p-4 translate-y-full group-hover:translate-y-0 transition-transform duration-200 flex justify-center">
                                    <span class="text-white text-xs font-medium bg-black/40 backdrop-blur-sm px-3 py-1 rounded-full border border-white/20">Change Primary</span>
                                </div>
                            @else
                                <div class="text-gray-400 flex flex-col items-center">
                                    <svg class="w-8 h-8 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    <span class="text-xs font-medium">Upload Image</span>
                                </div>
                            @endif
                            <input type="file" name="primary_image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        </div>

                        <!-- Gallery Thumbnails -->
                        <div class="grid grid-cols-4 gap-2">
                             @foreach($product->images as $img)
                                <div class="relative group aspect-square rounded border border-gray-200 overflow-hidden bg-gray-50">
                                    <img src="{{ Str::startsWith($img->image_path, 'http') ? $img->image_path : asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                                    <button type="button" onclick="deleteImage('{{ route('admin.product-images.destroy', $img->id) }}')" 
                                            class="absolute top-1 right-1 bg-red-600 hover:bg-red-700 text-white p-1.5 rounded-full shadow-md transition-all hover:scale-110" title="Delete Image">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            @endforeach
                            <div class="relative aspect-square rounded border border-dashed border-gray-300 hover:border-blue-500 hover:bg-blue-50 transition-all flex flex-col items-center justify-center cursor-pointer group bg-gray-50/50">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                <input type="file" name="product_images[]" multiple accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Specs (col-span-4) -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">Technical Details</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Warranty</label>
                                <div class="relative rounded-md shadow-sm">
                                    <input type="number" name="warranty_months" value="{{ old('warranty_months', $product->warranty_months) }}" required min="0" 
                                           class="block w-full rounded-md border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900 py-1.5 pr-8">
                                    <div class="absolute inset-y-0 right-0 pr-2 flex items-center pointer-events-none">
                                        <span class="text-gray-400 text-xs">M</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">In The Box</h2>
                        <div>
                            <textarea name="whats_in_box" rows="2" class="block w-full rounded-md border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900 shadow-sm py-1.5 resize-y">{{ old('whats_in_box', $product->whats_in_box) }}</textarea>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">Description</h2>
                        <div>
                            <textarea name="description" rows="4" class="block w-full rounded-md border-gray-300 text-sm focus:ring-gray-900 focus:border-gray-900 shadow-sm resize-y">{{ old('description', $product->description) }}</textarea>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<form id="delete-image-form" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<script>
    function deleteImage(url) {
        if (confirm('Delete this image?')) {
            const form = document.getElementById('delete-image-form');
            form.action = url;
            form.submit();
        }
    }

    document.getElementById('brand_id').addEventListener('change', function() {
        const brandId = this.value;
        const modelSelect = document.getElementById('phone_model_id');
        const optgroups = modelSelect.querySelectorAll('optgroup');
        
        if (this.dataset.userInteraction) {
            modelSelect.value = '';
        }
        this.dataset.userInteraction = 'true';

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
        
        const selectedOption = modelSelect.options[modelSelect.selectedIndex];
        if (selectedOption && selectedOption.parentElement.hidden) {
             modelSelect.value = '';
        }
    });
</script>
@endsection
