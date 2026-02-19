@extends('layouts.app')

@section('title', 'My Wishlist — PhoneShop')

@section('content')
<div class="bg-gray-50 min-h-screen pt-24 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center gap-4 mb-8 fade-in-section">
            <h1 class="text-3xl font-black text-gray-900 line-clamp-1">My Wishlist</h1>
            @if($products->count() > 0)
                <span class="bg-blue-100 text-blue-600 text-xs font-bold px-3 py-1 rounded-full">
                    {{ $products->count() }} {{ Str::plural('Item', $products->count()) }}
                </span>
            @endif
        </div>

        @if($products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 fade-in-section delay-100">
                @foreach($products as $product)
                    <div class="relative group">
                        <x-product-card :product="$product" />
                        
                        <!-- Remove button overlay for wishlist specifically -->
                        <div class="absolute top-3 right-14 z-10">
                            <form action="{{ route('wishlist.toggle', $product) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="p-2 rounded-full bg-red-50 text-red-500 shadow-sm border border-red-100 hover:bg-red-500 hover:text-white transition-all duration-200"
                                        title="Remove from wishlist">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-28 bg-white rounded-3xl border border-gray-100 shadow-sm fade-in-section">
                <div class="w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-gray-900 mb-3">Your wishlist is empty</h2>
                <p class="text-gray-500 mb-10">Save items you're interested in to keep track of them.</p>
                <a href="{{ route('products.index') }}"
                   class="btn-ripple inline-flex items-center gap-2 bg-gray-900 text-white font-bold px-10 py-4 rounded-2xl hover:bg-black transition-all shadow-xl shadow-gray-900/25 hover:scale-105 active:scale-95">
                    Explore Phones
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        @endif

        <!-- Recommendations or Continue Shopping -->
        <div class="mt-16 text-center">
            <h3 class="text-lg font-bold text-gray-900 mb-6">Need help choosing?</h3>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('compare.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">Compare Models</a>
                <a href="{{ route('sell') }}" class="px-6 py-3 rounded-xl border border-gray-200 text-sm font-bold text-gray-600 hover:bg-gray-50 transition-colors">Exchange Your Phone</a>
            </div>
        </div>
    </div>
</div>
@endsection
