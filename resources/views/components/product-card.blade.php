@props(['product'])

<div class="product-card group relative bg-white border border-gray-100 rounded-2xl overflow-hidden hover:border-blue-100 hover:shadow-2xl hover:shadow-blue-500/10 transition-all duration-500 flex flex-col h-full">
    <!-- Image Area -->
    <a href="{{ route('products.show', $product->slug) }}" class="block relative overflow-hidden bg-gradient-to-br from-gray-50 to-gray-100 aspect-square">
        <img src="{{ $product->primary_image_url }}"
             alt="{{ $product->title }}"
             class="product-card-img w-full h-full object-contain p-6">

        <!-- Condition Badge -->
        <div class="absolute top-3 left-3">
            @php $condition = $product->condition->name ?? 'Refurbished'; @endphp
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                @if($condition === 'Excellent') bg-emerald-50 text-emerald-700 border border-emerald-200
                @elseif($condition === 'Good') bg-blue-50 text-blue-700 border border-blue-200
                @else bg-amber-50 text-amber-700 border border-amber-200
                @endif">
                <span class="w-1.5 h-1.5 rounded-full
                    @if($condition === 'Excellent') bg-emerald-500
                    @elseif($condition === 'Good') bg-blue-500
                    @else bg-amber-500
                    @endif"></span>
                {{ $condition }}
            </span>
        </div>

        <!-- Quick View Overlay -->
        <div class="absolute inset-0 bg-gray-900/0 group-hover:bg-gray-900/5 transition-all duration-300 flex items-end justify-center pb-4 opacity-0 group-hover:opacity-100">
            <span class="bg-white text-gray-900 text-xs font-bold px-4 py-2 rounded-full shadow-lg transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                Quick View →
            </span>
        </div>
    </a>



    <!-- Info Area -->
    <div class="p-5 flex flex-col flex-grow">
        <div class="flex-grow">
            <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mb-1">{{ $product->phoneModel->brand->name }}</p>
            <h3 class="text-sm font-semibold text-gray-900 leading-snug line-clamp-2 group-hover:text-blue-600 transition-colors duration-200">
                <a href="{{ route('products.show', $product->slug) }}">{{ $product->title }}</a>
            </h3>
            <div class="flex flex-wrap gap-1.5 mt-2">
                @if($product->storage)
                    <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">{{ $product->storage }}</span>
                @endif
                @if($product->color)
                    <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">{{ $product->color }}</span>
                @endif
            </div>
        </div>

        <!-- Rating -->
        <div class="flex items-center gap-1.5 mt-3">
            <div class="flex">
                @for($i = 1; $i <= 5; $i++)
                    <svg class="w-3.5 h-3.5 {{ $i <= round($product->average_rating) ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                @endfor
            </div>
            <span class="text-xs text-gray-400">({{ $product->reviews_count ?? 0 }})</span>
        </div>

        <!-- Price + CTA -->
        <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-50">
            <div>
                <span class="text-xl font-black text-gray-900">₹{{ number_format($product->price, 0) }}</span>
                @if($product->original_price > $product->price)
                    <span class="block text-xs text-gray-400 line-through">₹{{ number_format($product->original_price, 0) }}</span>
                @endif
            </div>
            <div class="flex items-center gap-2">
                <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="p-2.5 rounded-xl bg-gray-50 hover:bg-gray-100 text-gray-400 hover:text-red-500 transition-colors group/wishlist">
                        <svg class="w-5 h-5 {{ $product->inWishlist() ? 'text-red-500 fill-current' : 'text-gray-400 group-hover/wishlist:text-red-500' }}" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                </form>

                <a href="{{ route('products.show', $product->slug) }}"
                   class="flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all duration-200 shadow-md shadow-blue-600/25 hover:shadow-blue-600/40 hover:scale-105 active:scale-95">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    Buy
                </a>
            </div>
        </div>
    </div>
</div>
