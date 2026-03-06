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
            <a href="{{ route('admin.products.index') }}" class="text-xs font-medium text-gray-600 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 px-3 py-2 rounded-lg transition-colors">
                ← Back
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
            
            <!-- Cumulative Multi-selection inputs storage -->
            <div id="hidden-inputs-container" class="hidden"></div>
            
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

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Select Brand</label>
                                    <div class="grid grid-cols-4 sm:grid-cols-5 gap-2">
                                        @foreach($brands as $brand)
                                            <button type="button" 
                                                    onclick="selectBrand('{{ $brand->id }}')"
                                                    data-brand-btn="{{ $brand->id }}"
                                                    class="brand-btn relative group aspect-square rounded-xl border-2 transition-all p-2 flex flex-col items-center justify-center gap-1 {{ $product->phoneModel->brand_id == $brand->id ? 'border-blue-600 bg-blue-50/50 shadow-sm' : 'border-gray-100 bg-white hover:border-gray-200 hover:bg-gray-50' }}">
                                                <div class="w-full h-8 flex items-center justify-center overflow-hidden">
                                                    <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" class="max-w-full max-h-full object-contain filter {{ $product->phoneModel->brand_id == $brand->id ? '' : 'grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100' }}">
                                                </div>
                                                <span class="text-[10px] font-bold truncate w-full text-center {{ $product->phoneModel->brand_id == $brand->id ? 'text-blue-700' : 'text-gray-400 group-hover:text-gray-600' }}">{{ $brand->name }}</span>
                                                
                                                @if($product->phoneModel->brand_id == $brand->id)
                                                    <div class="absolute -top-1.5 -right-1.5 w-5 h-5 bg-blue-600 rounded-full flex items-center justify-center border-2 border-white shadow-sm">
                                                        <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                    </div>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="brand_id" id="hidden_brand_id" value="{{ $product->phoneModel->brand_id }}">
                                </div>

                                <input type="hidden" name="phone_model_id" value="{{ $product->phone_model_id }}">
                            </div>
                            
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Price</label>
                                <div class="relative rounded-md shadow-sm">
                                    <span class="absolute left-3 top-1.5 text-gray-400 text-sm">₹</span>
                                    <input type="number" name="base_price" value="{{ old('base_price', $product->base_price) }}" required min="0" step="0.01"
                                           class="block w-full rounded-md border-gray-300 pl-7 text-sm font-bold text-gray-900 focus:ring-gray-900 focus:border-gray-900 py-1.5">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">Original Price (MRP)</label>
                                <div class="relative rounded-md shadow-sm">
                                    <span class="absolute left-3 top-1.5 text-gray-400 text-sm">₹</span>
                                    <input type="number" name="original_price" value="{{ old('original_price', $product->original_price) }}" min="0" step="0.01"
                                           class="block w-full rounded-md border-gray-300 pl-7 text-sm text-gray-500 focus:ring-gray-900 focus:border-gray-900 py-1.5">
                                </div>
                            </div>

                            <div class="pt-3 flex gap-6 flex-wrap">
                                @foreach([
                                    ['name' => 'is_active',    'label' => 'Active',    'checked' => old('is_active',    $product->is_active)],
                                    ['name' => 'is_featured',  'label' => 'Featured',  'checked' => old('is_featured',  $product->is_featured)],
                                    ['name' => 'is_available', 'label' => 'Available', 'checked' => old('is_available', $product->is_available)],
                                ] as $toggle)
                                <label class="inline-flex items-center gap-3 cursor-pointer select-none" onclick="toggleSwitch(this)">
                                    <input type="checkbox" name="{{ $toggle['name'] }}" value="1" {{ $toggle['checked'] ? 'checked' : '' }} class="hidden">
                                    <span class="toggle-track relative inline-block w-14 h-8 rounded-full transition-all duration-300"
                                          style="background: {{ $toggle['checked'] ? 'linear-gradient(to right, #34d399, #60a5fa)' : '#d1d5db' }}">
                                        <span class="toggle-thumb absolute top-1 left-1 w-6 h-6 bg-white rounded-full shadow-md transition-all duration-300"
                                              style="transform: {{ $toggle['checked'] ? 'translateX(24px)' : 'translateX(0)' }}"></span>
                                    </span>
                                    <span class="text-sm font-medium text-gray-700">{{ $toggle['label'] }}</span>
                                </label>
                                @endforeach
                            </div>
                            <script>
                            function toggleSwitch(label) {
                                const cb    = label.querySelector('input[type=checkbox]');
                                const track = label.querySelector('.toggle-track');
                                const thumb = label.querySelector('.toggle-thumb');
                                cb.checked = !cb.checked;
                                track.style.background = cb.checked ? 'linear-gradient(to right, #34d399, #60a5fa)' : '#d1d5db';
                                thumb.style.transform  = cb.checked ? 'translateX(24px)' : 'translateX(0)';
                            }
                            </script>
                        </div>
                    </div>
                </div>

                <!-- Middle Column: Images (col-span-4) -->
                <div class="lg:col-span-4 space-y-4">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
                        <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4 border-b pb-2">Visuals</h2>
                        
                        <!-- Main Preview -->
                        <div class="h-48 w-full bg-gray-50 rounded-lg border border-gray-200 relative group overflow-hidden mb-4 flex items-center justify-center cursor-pointer">
                            <img src="{{ $product->primary_image_url }}" 
                                 class="max-w-full max-h-full object-contain p-2 pointer-events-none">
                            
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition-all duration-200 flex items-center justify-center pointer-events-none">
                                <span class="opacity-0 group-hover:opacity-100 transition-opacity text-white text-xs font-bold bg-black/50 backdrop-blur-sm px-4 py-2 rounded-full border border-white/30 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a4 4 0 01-2.828 1.172H7v-2a4 4 0 011.172-2.828z"/></svg>
                                    Click to Change
                                </span>
                            </div>
                            
                            <input type="file" name="primary_image" accept="image/*" 
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                   onchange="previewPrimaryImage(this)">
                        </div>

                        <!-- Gallery Thumbnails -->
                        <div id="gallery-grid" class="grid grid-cols-4 gap-2">
                             @foreach($product->images as $img)
                                <div class="relative group aspect-square rounded border border-gray-200 overflow-hidden bg-gray-50">
                                    <img src="{{ $img->url }}" class="w-full h-full object-cover">
                                    <button type="button" onclick="deleteImage('{{ route('admin.product-images.destroy', $img->id) }}')" 
                                            class="absolute top-1 right-1 bg-red-600 hover:bg-red-700 text-white p-1.5 rounded-full shadow-md transition-all hover:scale-110" title="Delete Image">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            @endforeach
                            <div id="new-previews" class="contents"></div>

                            <div id="gallery-input-wrapper" class="relative aspect-square rounded border border-dashed border-gray-300 hover:border-blue-500 hover:bg-blue-50 transition-all flex flex-col items-center justify-center cursor-pointer group bg-gray-50/50">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-blue-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                <input type="file" name="product_images[]" multiple accept="image/*" 
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                       onchange="previewGalleryImages(this)">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Details (col-span-4) -->
                <div class="lg:col-span-4 space-y-4">
                    <!-- Product Details Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/60">
                            <h2 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Product Details</h2>
                        </div>
                        <div class="p-5 space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-gray-500">Storage</label>
                                    <div class="relative border-l-4 border-gray-200 focus-within:border-l-orange-400 transition-colors rounded-r-md">
                                        <input type="text" name="storage" value="{{ old('storage', $product->storage) }}" required placeholder="e.g. 128GB"
                                               class="block w-full border border-l-0 border-gray-200 rounded-r-md text-sm focus:ring-0 focus:border-gray-300 py-2 px-3 bg-white placeholder-gray-300">
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-gray-500">Color</label>
                                    <div class="relative border-l-4 border-gray-200 focus-within:border-l-orange-400 transition-colors rounded-r-md">
                                        <input type="text" name="color" value="{{ old('color', $product->color) }}" required placeholder="e.g. Blue"
                                               class="block w-full border border-l-0 border-gray-200 rounded-r-md text-sm focus:ring-0 focus:border-gray-300 py-2 px-3 bg-white placeholder-gray-300">
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500">Condition</label>
                                <div class="relative border-l-4 border-gray-200 focus-within:border-l-orange-400 transition-colors rounded-r-md">
                                    <select name="condition_id" required class="block w-full border border-l-0 border-gray-200 rounded-r-md text-sm focus:ring-0 focus:border-gray-300 py-2 px-3 bg-white">
                                        <option value="">Select Condition</option>
                                        @foreach($conditions as $condition)
                                            <option value="{{ $condition->id }}" {{ old('condition_id', $product->condition_id) == $condition->id ? 'selected' : '' }}>{{ $condition->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-gray-500">Stock</label>
                                    <div class="relative border-l-4 border-gray-200 focus-within:border-l-orange-400 transition-colors rounded-r-md">
                                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                                               class="block w-full border border-l-0 border-gray-200 rounded-r-md text-sm focus:ring-0 focus:border-gray-300 py-2 px-3 bg-white">
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-xs font-semibold text-gray-500">SKU</label>
                                    <div class="relative border-l-4 border-gray-200 focus-within:border-l-orange-400 transition-colors rounded-r-md">
                                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required
                                               class="block w-full border border-l-0 border-gray-200 rounded-r-md text-sm focus:ring-0 focus:border-gray-300 py-2 px-3 bg-white font-mono">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Technical Details Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/60">
                            <h2 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Technical Details</h2>
                        </div>
                        <div class="p-5">
                            <div class="space-y-1">
                                <label class="text-xs font-semibold text-gray-500">Warranty <span class="text-gray-300 font-normal">(months)</span></label>
                                <div class="relative border-l-4 border-gray-200 focus-within:border-l-orange-400 transition-colors rounded-r-md">
                                    <input type="number" name="warranty_months" value="{{ old('warranty_months', $product->warranty_months) }}" required min="0"
                                           class="block w-full border border-l-0 border-gray-200 rounded-r-md text-sm focus:ring-0 focus:border-gray-300 py-2 px-3 pr-16 bg-white">
                                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400 font-medium pointer-events-none">months</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- In The Box Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/60">
                            <h2 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">In The Box</h2>
                        </div>
                        <div class="p-5">
                            <div class="relative border-l-4 border-gray-200 focus-within:border-l-orange-400 transition-colors rounded-r-md">
                                <textarea name="whats_in_box" rows="2"
                                          class="block w-full border border-l-0 border-gray-200 rounded-r-md text-sm focus:ring-0 focus:border-gray-300 py-2 px-3 bg-white resize-y placeholder-gray-300"
                                          placeholder="e.g. Phone, Cable, Adapter...">{{ old('whats_in_box', $product->whats_in_box) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Description Card -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/60">
                            <h2 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest">Description</h2>
                        </div>
                        <div class="p-5">
                            <div class="relative border-l-4 border-gray-200 focus-within:border-l-orange-400 transition-colors rounded-r-md">
                                <textarea name="description" rows="4"
                                          class="block w-full border border-l-0 border-gray-200 rounded-r-md text-sm focus:ring-0 focus:border-gray-300 py-2 px-3 bg-white resize-y placeholder-gray-300"
                                          placeholder="Describe the product condition, features...">{{ old('description', $product->description) }}</textarea>
                            </div>
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
    function previewPrimaryImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const container = input.closest('div');
                const img = container.querySelector('img');
                if (img) img.src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewGalleryImages(input) {
        const previewContainer = document.getElementById('new-previews');
        const hiddenContainer = document.getElementById('hidden-inputs-container');
        const wrapper = document.getElementById('gallery-input-wrapper');
        
        if (input.files && input.files.length > 0) {
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative aspect-square rounded border border-gray-200 overflow-hidden bg-gray-50 animate-pulse';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-blue-500/10 flex items-center justify-center">
                            <span class="bg-blue-600 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow-sm">NEW</span>
                        </div>
                    `;
                    previewContainer.appendChild(div);
                    setTimeout(() => div.classList.remove('animate-pulse'), 500);
                };
                reader.readAsDataURL(file);
            });

            input.onchange = null;
            input.classList.add('hidden');
            hiddenContainer.appendChild(input);

            const nextInput = document.createElement('input');
            nextInput.type = 'file';
            nextInput.name = 'product_images[]';
            nextInput.multiple = true;
            nextInput.accept = 'image/*';
            nextInput.className = 'absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10';
            nextInput.onchange = function() { previewGalleryImages(this); };
            wrapper.appendChild(nextInput);
        }
    }

    function deleteImage(url) {
        if (confirm('Delete this image?')) {
            const form = document.getElementById('delete-image-form');
            form.action = url;
            form.submit();
        }
    }

    function selectBrand(brandId) {
        document.getElementById('hidden_brand_id').value = brandId;

        document.querySelectorAll('.brand-btn').forEach(btn => {
            if (btn.dataset.brandBtn === brandId) {
                btn.classList.add('border-blue-600', 'bg-blue-50/50', 'shadow-sm');
                btn.classList.remove('border-gray-100', 'bg-white', 'hover:border-gray-200', 'hover:bg-gray-50');
                btn.querySelector('img').classList.remove('grayscale', 'opacity-70');
                btn.querySelector('span').classList.add('text-blue-700');
                btn.querySelector('span').classList.remove('text-gray-400');
                
                if (!btn.querySelector('.absolute')) {
                    const check = document.createElement('div');
                    check.className = 'absolute -top-1.5 -right-1.5 w-5 h-5 bg-blue-600 rounded-full flex items-center justify-center border-2 border-white shadow-sm';
                    check.innerHTML = '<svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>';
                    btn.appendChild(check);
                }
            } else {
                btn.classList.remove('border-blue-600', 'bg-blue-50/50', 'shadow-sm');
                btn.classList.add('border-gray-100', 'bg-white', 'hover:border-gray-200', 'hover:bg-gray-50');
                btn.querySelector('img').classList.add('grayscale', 'opacity-70');
                btn.querySelector('span').classList.remove('text-blue-700');
                btn.querySelector('span').classList.add('text-gray-400');
                
                const check = btn.querySelector('.absolute');
                if (check) check.remove();
            }
        });

        const modelSelect = document.getElementById('phone_model_id');
        const optgroups = modelSelect.querySelectorAll('optgroup');
        
        modelSelect.value = '';

        optgroups.forEach(group => {
            if (group.dataset.brand === brandId) {
                group.hidden = false;
            } else {
                group.hidden = true;
            }
        });
    }
</script>
@endsection
