@extends('layouts.app')

@section('title', $product->title . ' - Refurbished Phones Shop')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Breadcrumb -->
        <nav class="mb-8 flex text-sm text-gray-500" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('products.index') }}" class="hover:text-indigo-600">Products</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900">{{ $product->title }}</span>
        </nav>

        <div class="lg:grid lg:grid-cols-2 lg:gap-x-12">
            <!-- Image Gallery -->
            <div class="space-y-4">
                <div class="aspect-w-4 aspect-h-3 bg-gray-100 rounded-2xl overflow-hidden border border-gray-100 group relative">
                    <img id="mainImage" src="{{ $product->primary_image ?? 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&q=80&w=800' }}" 
                         alt="{{ $product->title }}" 
                         class="h-full w-full object-cover transition-all duration-500 group-hover:scale-105">
                    
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/90 text-indigo-800 shadow-sm backdrop-blur-sm">
                            Certified Refurbished
                        </span>
                    </div>
                </div>

                @if($product->images->count() > 0)
                    <div class="grid grid-cols-4 gap-4">
                        <button onclick="changeImage('{{ $product->primary_image }}', this)" class="aspect-w-1 aspect-h-1 rounded-lg border-2 border-indigo-500 p-1 bg-white">
                            <img src="{{ $product->primary_image }}" class="w-full h-full object-cover rounded-md">
                        </button>
                        @foreach($product->images as $image)
                            <button onclick="changeImage('{{ $image->image_path }}', this)" class="aspect-w-1 aspect-h-1 rounded-lg border-2 border-transparent p-1 bg-white hover:border-indigo-200 transition-all">
                                <img src="{{ $image->image_path }}" class="w-full h-full object-cover rounded-md">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="mt-10 lg:mt-0 flex flex-col">
                <div class="border-b border-gray-100 pb-6">
                    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight sm:text-4xl">{{ $product->title }}</h1>
                    <div class="mt-3 flex items-center space-x-4">
                        <div class="flex items-center text-yellow-400">
                             @for($i=0; $i<5; $i++)
                                <span>{{ $i < round($product->average_rating) ? '⭐' : '☆' }}</span>
                             @endfor
                        </div>
                        <span class="text-sm text-gray-500">({{ $product->reviews_count }} customer reviews)</span>
                        <span class="text-gray-300">|</span>
                        <span class="text-sm font-medium text-indigo-600">Brand: {{ $product->phoneModel->brand->name }}</span>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="flex items-center justify-between">
                        <div class="text-4xl font-bold text-gray-900">₹{{ number_format($product->base_price, 0) }}</div>
                        <div class="text-sm text-green-600 font-bold bg-green-50 px-3 py-1 rounded-full flex items-center">
                            <span class="mr-1">✓</span> In Stock
                        </div>
                    </div>
                    <p class="mt-4 text-gray-600 leading-relaxed">{{ $product->description ?? 'Expertly restored to original functionality. This device has passed our 90-point inspection and comes with a full 12-month warranty for your peace of mind.' }}</p>
                </div>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.store') }}" method="POST" class="mt-10 space-y-8">
                    @csrf
                    
                    <!-- Variant Selection -->
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Select Variant</h3>
                        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                            @foreach($product->variants as $variant)
                                <label class="relative border rounded-xl p-4 flex cursor-pointer hover:border-indigo-600 transition-all {{ $loop->first ? 'border-indigo-600 ring-2 ring-indigo-600/10' : 'border-gray-200' }}">
                                    <input type="radio" name="variant_id" value="{{ $variant->id }}" class="sr-only" {{ $loop->first ? 'checked' : '' }}>
                                    <div class="flex-1 flex flex-col">
                                        <span class="text-sm font-bold text-gray-900">{{ $variant->storage }} | {{ $variant->color }}</span>
                                        <span class="mt-1 text-xs text-gray-500">Condition: {{ $variant->condition->name }} Grade</span>
                                        <span class="mt-2 text-sm font-bold text-indigo-600">₹{{ number_format($variant->price, 0) }}</span>
                                    </div>
                                    <div class="flex items-center text-indigo-600 check-icon {{ $loop->first ? 'block' : 'hidden' }}">
                                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-end space-x-4">
                        <div class="w-32">
                            <label for="quantity" class="text-sm font-bold text-gray-900 uppercase tracking-wider">Quantity</label>
                            <select name="quantity" id="quantity" class="mt-1 block w-full border-gray-200 rounded-lg py-3 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium text-gray-700">
                                @for($i=1; $i<=5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit" class="flex-1 w-full bg-indigo-600 border border-transparent rounded-lg py-3 px-8 text-base font-bold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg shadow-indigo-600/20 transform active:scale-[0.98] transition-all">
                            Add to Cart
                        </button>
                    </div>
                </form>

                <!-- Features/Warranty -->
                <div class="mt-12 grid grid-cols-3 gap-6 border-t border-gray-100 pt-8">
                    <div class="text-center">
                        <div class="text-2xl mb-1">🛡️</div>
                        <p class="text-[10px] font-bold text-gray-400 tracking-wider uppercase">1-Year Warranty</p>
                    </div>
                    <div class="text-center border-x border-gray-100 px-4">
                        <div class="text-2xl mb-1">✅</div>
                        <p class="text-[10px] font-bold text-gray-400 tracking-wider uppercase">Quality Checked</p>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl mb-1">🔄</div>
                        <p class="text-[10px] font-bold text-gray-400 tracking-wider uppercase">30-Day Return</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function changeImage(src, btn) {
        document.getElementById('mainImage').src = src;
        
        // Update thumbnail borders
        const buttons = btn.parentElement.querySelectorAll('button');
        buttons.forEach(b => {
             b.classList.remove('border-indigo-500');
             b.classList.add('border-transparent');
        });
        btn.classList.remove('border-transparent');
        btn.classList.add('border-indigo-500');
    }

    // Handle variant selection styling
    document.querySelectorAll('input[name="variant_id"]').forEach(input => {
        input.addEventListener('change', function() {
            // Remove styles from all
            document.querySelectorAll('input[name="variant_id"]').forEach(i => {
                const label = i.closest('label');
                label.classList.remove('border-indigo-600', 'ring-2', 'ring-indigo-600/10');
                label.classList.add('border-gray-200');
                label.querySelector('.check-icon').classList.add('hidden');
            });

            // Add styles to selected
            if (this.checked) {
                const label = this.closest('label');
                label.classList.remove('border-gray-200');
                label.classList.add('border-indigo-600', 'ring-2', 'ring-indigo-600/10');
                label.querySelector('.check-icon').classList.remove('hidden');
            }
        });
    });
</script>
@endsection
