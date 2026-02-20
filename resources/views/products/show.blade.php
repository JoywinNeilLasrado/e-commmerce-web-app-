@extends('layouts.app')

@section('title', $product->title . ' — PhoneShop')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-10">

        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-gray-400 mb-10 fade-in-section">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Home</a>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('products.index') }}" class="hover:text-blue-600 transition-colors">Products</a>
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-700 font-medium truncate max-w-xs">{{ $product->title }}</span>
        </nav>

        <div class="grid lg:grid-cols-12 gap-12">

            <!-- Left: Image Gallery -->
            <div class="lg:col-span-5 fade-in-section">
                <div class="sticky top-28">
                    <!-- Main Image -->
                    <div class="relative bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl overflow-hidden aspect-square mb-4 group">
                        <img id="mainImage"
                             src="{{ $product->primary_image_url }}"
                             alt="{{ $product->title }}"
                             class="w-full h-full object-contain p-10 transition-all duration-500 group-hover:scale-105">

                        <!-- Navigation Arrows -->
                        <div class="absolute inset-0 flex items-center justify-between px-4 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button onclick="prevImage()" class="p-2.5 rounded-full bg-white/90 backdrop-blur-md shadow-lg border border-gray-100 text-gray-900 hover:bg-blue-600 hover:text-white transition-all transform hover:scale-110 active:scale-95">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                            </button>
                            <button onclick="nextImage()" class="p-2.5 rounded-full bg-white/90 backdrop-blur-md shadow-lg border border-gray-100 text-gray-900 hover:bg-blue-600 hover:text-white transition-all transform hover:scale-110 active:scale-95">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>

                        @php $condition = $product->variants->first()?->condition?->name ?? 'Refurbished'; @endphp
                        <div class="absolute top-5 left-5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold
                                @if($condition === 'Excellent') bg-emerald-100 text-emerald-700
                                @elseif($condition === 'Good') bg-blue-100 text-blue-700
                                @else bg-amber-100 text-amber-700
                                @endif">
                                <span class="w-1.5 h-1.5 rounded-full
                                    @if($condition === 'Excellent') bg-emerald-500
                                    @elseif($condition === 'Good') bg-blue-500
                                    @else bg-amber-500
                                    @endif"></span>
                                {{ $condition }} Condition
                            </span>
                        </div>
                    </div>

                    <!-- Thumbnails -->
                    @if($product->images->count() > 0)
                        <div class="grid grid-cols-5 gap-2">
                            <button onclick="changeImage('{{ $product->primary_image_url }}', this)"
                                    class="thumbnail-btn aspect-square rounded-xl overflow-hidden border-2 border-blue-500 bg-gray-50 p-1.5 transition-all">
                                <img src="{{ $product->primary_image_url }}" class="w-full h-full object-contain">
                            </button>
                            @foreach($product->images->take(4) as $image)
                                <button onclick="changeImage('{{ $image->url }}', this)"
                                        class="thumbnail-btn aspect-square rounded-xl overflow-hidden border-2 border-transparent bg-gray-50 p-1.5 hover:border-blue-300 transition-all">
                                    <img src="{{ $image->url }}" class="w-full h-full object-contain">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Middle: Product Info -->
            <div class="lg:col-span-4 fade-in-section delay-100">
                <div class="mb-2">
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">{{ $product->phoneModel->brand->name }}</span>
                </div>
                <h1 class="text-3xl font-black text-gray-900 leading-tight mb-4">{{ $product->title }}</h1>

                <!-- Rating -->
                @php $avgRating = $product->average_rating; @endphp
                <div class="flex items-center gap-3 mb-6">
                    <div class="flex items-center gap-1">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                    <span class="text-sm font-bold text-gray-900">{{ number_format($avgRating, 1) }}</span>
                    <span class="text-sm text-gray-400">({{ $product->reviews_count }} reviews)</span>
                </div>

                <!-- Description -->
                <p class="text-gray-600 leading-relaxed mb-8 text-sm">
                    {{ $product->description ?? 'Expertly restored to original functionality. This device has passed our 90-point inspection and comes with a full 12-month warranty for your peace of mind.' }}
                </p>

                <!-- What's in the Box -->
                @if($product->whats_in_box)
                    <div class="bg-gray-50 rounded-2xl p-6 mb-8">
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">What's in the Box</h3>
                        <p class="text-sm text-gray-700">{{ $product->whats_in_box }}</p>
                    </div>
                @endif

                <!-- Warranty -->
                @if($product->warranty_months)
                    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 mb-8 flex items-center gap-4">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-blue-900">{{ $product->warranty_months }}-Month Warranty Included</p>
                            <p class="text-xs text-blue-600 mt-0.5">Full coverage for any technical defaults</p>
                        </div>
                    </div>
                @endif

                <!-- Trust Badges -->
                <div class="grid grid-cols-3 gap-3">
                    <div class="text-center bg-gray-50 rounded-xl p-3">
                        <svg class="w-5 h-5 text-blue-600 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <p class="text-[10px] font-bold text-gray-600">Warranty</p>
                    </div>
                    <div class="text-center bg-gray-50 rounded-xl p-3">
                        <svg class="w-5 h-5 text-emerald-600 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <p class="text-[10px] font-bold text-gray-600">30-Day Returns</p>
                    </div>
                    <div class="text-center bg-gray-50 rounded-xl p-3">
                        <svg class="w-5 h-5 text-purple-600 mx-auto mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/></svg>
                        <p class="text-[10px] font-bold text-gray-600">Free Shipping</p>
                    </div>
                </div>

                <!-- Reviews Section -->
                <div id="reviews" class="mt-12 pt-10 border-t border-gray-100">
                    <h3 class="text-xl font-black text-gray-900 mb-6">Customer Reviews</h3>
                    
                    <!-- Write Review Form -->
                    @auth
                        <form action="{{ route('reviews.store') }}" method="POST" class="mb-10 bg-gray-50 rounded-2xl p-6 border border-gray-100">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Rating</label>
                                    <div class="flex items-center gap-1 group/stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button" onclick="setRating({{ $i }})" 
                                                    class="star-btn transition-colors focus:outline-none text-gray-300 hover:text-amber-400 p-1" 
                                                    data-rating="{{ $i }}">
                                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            </button>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="rating" id="rating-input" required>
                                    <p id="rating-error" class="text-red-500 text-xs mt-1 hidden">Please select a rating</p>
                                </div>
                                
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Your Review <span class="text-gray-400 font-normal lowercase">(optional)</span></label>
                                    <textarea name="comment" rows="3" placeholder="Share your experience with this phone..."
                                              class="w-full rounded-xl border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 mb-3"></textarea>
                                    
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-6 rounded-xl text-sm transition-all shadow-md shadow-blue-600/20 float-right">
                                        Submit Review
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="mb-10 bg-blue-50/50 rounded-2xl p-6 border border-blue-100 flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-bold text-blue-900">Have you used this product?</h4>
                                <p class="text-sm text-blue-700 mt-0.5">Share your thoughts with other customers</p>
                            </div>
                            <a href="{{ route('login') }}" class="bg-white text-blue-600 font-bold py-2 px-6 rounded-xl text-sm border border-blue-200 hover:bg-blue-50 transition-colors shadow-sm">
                                Login to Review
                            </a>
                        </div>
                    @endauth

                    @if($product->reviews->count() > 0)
                        <div class="space-y-4">
                            @foreach($product->reviews->where('is_approved', true) as $review)
                                <div class="bg-gray-50 rounded-2xl p-5 border border-gray-100">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-sm">
                                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <span class="block text-sm font-bold text-gray-900">{{ $review->user->name }}</span>
                                                <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                        <div class="flex bg-white px-2 py-1 rounded-lg border border-gray-100 shadow-sm">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @endfor
                                        </div>
                                    </div>
                                    @if($review->comment)
                                        <p class="text-sm text-gray-600 leading-relaxed">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                            </div>
                            <h5 class="text-sm font-bold text-gray-900">No reviews yet</h5>
                            <p class="text-xs text-gray-500 mt-1">Be the first to share your experience!</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right: Buy Box -->
            <div class="lg:col-span-3 fade-in-section delay-200">
                <div class="bg-white border border-gray-200 rounded-3xl p-6 shadow-xl shadow-gray-100/80 sticky top-28">
                    <form action="{{ route('cart.store') }}" method="POST">
                        @csrf

                        <!-- Price -->
                        <div class="mb-6">
                            <div class="flex items-baseline gap-3">
                                <p id="product-price" class="text-4xl font-black text-gray-900">₹{{ number_format($product->base_price, 0) }}</p>
                                <p id="product-original-price" class="text-lg text-gray-400 line-through {{ $product->original_price ? '' : 'hidden' }}">₹{{ number_format($product->original_price, 0) }}</p>
                            </div>
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                    In Stock
                                </span>
                                <span class="text-xs text-gray-400">Free delivery</span>
                            </div>
                        </div>

                        <!-- Variant Selection -->
                        @if($product->variants->count() > 0)
                            <div class="mb-5">
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-3">Select Variant</label>
                                <div class="space-y-2.5 max-h-52 overflow-y-auto pr-1">
                                    @foreach($product->variants as $variant)
                                    <label class="relative flex items-center gap-3 p-3.5 border-2 rounded-xl cursor-pointer transition-all duration-200 {{ $loop->first ? 'border-blue-500 bg-blue-50' : 'border-gray-100 hover:border-blue-200 hover:bg-gray-50' }}">
                                            <input type="radio" name="variant_id" value="{{ $variant->id }}" 
                                                   data-price="{{ $variant->price }}" 
                                                   data-original-price="{{ $variant->original_price ?? '' }}"
                                                   data-stock="{{ $variant->stock }}"
                                                   class="sr-only" {{ $loop->first ? 'checked' : '' }}>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2">
                                                    <p class="text-sm font-bold {{ $variant->stock == 0 ? 'text-gray-400' : 'text-gray-900' }}">
                                                        {{ $variant->storage }} · {{ $variant->color }}
                                                    </p>
                                                    @if($variant->stock == 0)
                                                        <span class="text-[10px] font-bold text-white bg-red-500 px-1.5 py-0.5 rounded">Out of Stock</span>
                                                    @endif
                                                </div>
                                                <p class="text-xs text-gray-500">{{ $variant->condition->name }} Grade</p>
                                            </div>
                                            <span class="text-sm font-black {{ $variant->stock == 0 ? 'text-gray-400' : 'text-blue-600' }} flex-shrink-0">₹{{ number_format($variant->price, 0) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Quantity -->
                        <div class="mb-6">
                            <label class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-2">Quantity</label>
                            <select name="quantity" class="w-full border border-gray-200 rounded-xl py-2.5 px-4 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 bg-gray-50">
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="space-y-3">
                            <button type="submit" name="action" value="add_to_cart"
                                    class="btn-ripple w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl transition-all duration-200 shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50 hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                Add to Cart
                            </button>
                            <button type="submit" name="action" value="buy_now"
                               class="w-full bg-gray-900 hover:bg-gray-800 text-white font-bold py-4 rounded-2xl transition-all duration-200 hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2">
                                Buy Now
                            </button>

                            <!-- Wishlist Toggle -->
                        </div>
                    </form>

                    <!-- Wishlist Toggle -->
                    <form action="{{ route('wishlist.toggle', $product) }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit"
                                class="w-full bg-white border border-gray-100 hover:border-red-100 hover:bg-red-50 text-gray-700 font-bold py-3.5 rounded-2xl transition-all duration-200 flex items-center justify-center gap-2 group/wishlist">
                            <svg class="w-5 h-5 {{ $product->inWishlist() ? 'text-red-500 fill-current' : 'text-gray-400 group-hover/wishlist:text-red-500' }}"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                            {{ $product->inWishlist() ? 'In Wishlist' : 'Save to Wishlist' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Image Gallery Logic
const galleryImages = [
    "{{ $product->primary_image_url }}",
    @foreach($product->images as $image)
        "{{ $image->url }}",
    @endforeach
];
let currentImageIndex = 0;

function updateMainImage() {
    const mainImg = document.getElementById('mainImage');
    const thumbnails = document.querySelectorAll('.thumbnail-btn');
    
    // Animation
    mainImg.style.opacity = '0';
    mainImg.style.transform = 'scale(0.95)';
    
    setTimeout(() => {
        mainImg.src = galleryImages[currentImageIndex];
        mainImg.style.opacity = '1';
        mainImg.style.transform = 'scale(1)';
        
        // Update thumbnails UI
        thumbnails.forEach((btn, index) => {
            if (index === currentImageIndex) {
                btn.classList.add('border-blue-500');
                btn.classList.remove('border-transparent');
            } else {
                btn.classList.remove('border-blue-500');
                btn.classList.add('border-transparent');
            }
        });
    }, 200);
}

function nextImage() {
    currentImageIndex = (currentImageIndex + 1) % galleryImages.length;
    updateMainImage();
}

function prevImage() {
    currentImageIndex = (currentImageIndex - 1 + galleryImages.length) % galleryImages.length;
    updateMainImage();
}

function changeImage(src, btn) {
    const index = galleryImages.indexOf(src);
    if (index !== -1) {
        currentImageIndex = index;
        updateMainImage();
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const priceDisplay = document.getElementById('product-price');
    const originalPriceDisplay = document.getElementById('product-original-price');
    const variantInputs = document.querySelectorAll('input[name="variant_id"]');
    const baseOriginalPrice = "{{ $product->original_price }}";
    const addToCartBtn = document.querySelector('button[value="add_to_cart"]');
    const buyNowBtn = document.querySelector('button[value="buy_now"]');

    function updateState(price, originalPrice, stock) {
        // 1. Update Price
        const formattedPrice = new Intl.NumberFormat('en-IN').format(price);
        priceDisplay.textContent = '₹' + formattedPrice;
        
        if (originalPrice && parseFloat(originalPrice) > parseFloat(price)) {
            const formattedOriginal = new Intl.NumberFormat('en-IN').format(originalPrice);
            originalPriceDisplay.textContent = '₹' + formattedOriginal;
            originalPriceDisplay.classList.remove('hidden');
        } else if (!originalPrice && baseOriginalPrice && parseFloat(baseOriginalPrice) > parseFloat(price)) {
            const formattedOriginal = new Intl.NumberFormat('en-IN').format(baseOriginalPrice);
            originalPriceDisplay.textContent = '₹' + formattedOriginal;
            originalPriceDisplay.classList.remove('hidden');
        } else {
            originalPriceDisplay.classList.add('hidden');
        }
        
        // Animation
        priceDisplay.classList.remove('scale-100');
        priceDisplay.classList.add('scale-105', 'text-blue-600');
        setTimeout(() => {
            priceDisplay.classList.remove('scale-105', 'text-blue-600');
            priceDisplay.classList.add('scale-100');
        }, 200);

        // 2. Update Buttons based on Stock
        if (parseInt(stock) === 0) {
            addToCartBtn.disabled = true;
            addToCartBtn.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                Out of Stock
            `;
            addToCartBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
            addToCartBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'shadow-blue-600/30', 'hover:shadow-blue-600/50', 'hover:scale-[1.02]');
            
            buyNowBtn.disabled = true;
            buyNowBtn.classList.add('opacity-50', 'cursor-not-allowed');
            buyNowBtn.classList.remove('hover:bg-gray-800', 'hover:scale-[1.02]');
        } else {
            addToCartBtn.disabled = false;
            addToCartBtn.innerHTML = `
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                Add to Cart
            `;
            addToCartBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            addToCartBtn.classList.add('bg-blue-600', 'hover:bg-blue-700', 'shadow-blue-600/30', 'hover:shadow-blue-600/50', 'hover:scale-[1.02]');
            
            buyNowBtn.disabled = false;
            buyNowBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            buyNowBtn.classList.add('hover:bg-gray-800', 'hover:scale-[1.02]');
        }
    }

    variantInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.checked) {
                updateState(this.dataset.price, this.dataset.originalPrice, this.dataset.stock);
            }
        });

        // Initialize with checked input
        if (input.checked) {
            updateState(input.dataset.price, input.dataset.originalPrice, input.dataset.stock);
        }
    });

    // Review System
    const starBtns = document.querySelectorAll('.star-btn');
    const ratingInput = document.getElementById('rating-input');
    const ratingError = document.getElementById('rating-error');

    window.setRating = function(rating) {
        if (!ratingInput) return;
        ratingInput.value = rating;
        if(ratingError) ratingError.classList.add('hidden');
        
        starBtns.forEach(btn => {
            const btnRating = parseInt(btn.dataset.rating);
            
            if (btnRating <= rating) {
                btn.classList.add('text-amber-400');
                btn.classList.remove('text-gray-300');
            } else {
                btn.classList.add('text-gray-300');
                btn.classList.remove('text-amber-400');
            }
        });
    }

    // Hover effects
    if (starBtns.length > 0) {
        const starContainer = document.querySelector('.group\\/stars');
        
        starContainer.addEventListener('mouseleave', () => {
            const currentRating = parseInt(ratingInput.value || 0);
            starBtns.forEach(b => {
                const bRating = parseInt(b.dataset.rating);
                if (bRating <= currentRating) {
                    b.classList.add('text-amber-400');
                    b.classList.remove('text-gray-300');
                } else {
                    b.classList.add('text-gray-300');
                    b.classList.remove('text-amber-400');
                }
            });
        });

        starBtns.forEach(btn => {
            btn.addEventListener('mouseenter', () => {
                const rating = parseInt(btn.dataset.rating);
                starBtns.forEach(b => {
                    if (parseInt(b.dataset.rating) <= rating) {
                        b.classList.add('text-amber-400');
                        b.classList.remove('text-gray-300');
                    } else {
                        b.classList.add('text-gray-300');
                        b.classList.remove('text-amber-400');
                    }
                });
            });
        });
    }
});
</script>
@endsection
