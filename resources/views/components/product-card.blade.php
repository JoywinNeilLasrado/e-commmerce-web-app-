@props(['product'])

<div class="group relative bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
    <!-- Image Area -->
    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-50 p-6 flex items-center justify-center relative">
        <img src="{{ $product->primary_image ?? 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&q=80&w=800' }}" 
             alt="{{ $product->title }}" 
             class="h-full w-full object-contain transition-transform duration-500 group-hover:scale-110">
        
        <!-- Condition Badge -->
        <div class="absolute top-4 left-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-indigo-50 text-indigo-700 border border-indigo-100 shadow-sm">
                {{ $product->variants->first()->condition->name ?? 'Refurbished' }}
            </span>
        </div>
    </div>

    <!-- Info Area -->
    <div class="p-6">
        <div>
            <h3 class="text-sm font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">
                <a href="{{ route('products.show', $product) }}">
                    <span aria-hidden="true" class="absolute inset-0"></span>
                    {{ $product->title }}
                </a>
            </h3>
            <p class="mt-1 text-xs text-gray-400 font-medium uppercase tracking-tighter">{{ $product->phoneModel->brand->name }}</p>
        </div>
        
        <div class="mt-4 flex items-center justify-between">
            <div class="flex flex-col">
                <span class="text-lg font-black text-gray-900">₹{{ number_format($product->base_price, 0) }}</span>
                @if($product->variants->first() && $product->variants->first()->original_price > $product->base_price)
                    <span class="text-[10px] text-gray-400 line-through">₹{{ number_format($product->variants->first()->original_price, 0) }}</span>
                @endif
            </div>
            
            <div class="flex items-center text-yellow-400 text-xs">
                ⭐ <span class="ml-1 text-gray-900 font-bold">{{ number_format($product->average_rating, 1) }}</span>
            </div>
        </div>

        <!-- Add to Cart Trigger (Subtle) -->
        <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between opacity-0 group-hover:opacity-100 transition-opacity">
            <span class="text-[10px] font-bold text-green-600 flex items-center">
                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1 animate-pulse"></span> In Stock
            </span>
            <span class="text-indigo-600 text-xs font-bold uppercase tracking-widest">View Details →</span>
        </div>
    </div>
</div>
