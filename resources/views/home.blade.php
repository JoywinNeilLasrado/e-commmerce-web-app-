@extends('layouts.app')

@section('title', 'PhoneShop — Premium Refurbished Phones')

@section('content')

<!-- Hero Section -->
<section class="relative overflow-hidden bg-white">
    <!-- Background Decoration -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-blue-50 rounded-full opacity-60 blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-[400px] h-[400px] bg-indigo-50 rounded-full opacity-40 blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 pb-24 lg:pt-32 lg:pb-36">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <!-- Left: Copy -->
            <div class="fade-in-section">
                <div class="inline-flex items-center gap-2 bg-blue-50 border border-blue-100 text-blue-700 text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full mb-8">
                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                    Certified Refurbished
                </div>

                <h1 class="text-5xl lg:text-6xl font-black text-gray-900 leading-[1.1] tracking-tight mb-6">
                    Premium Tech.<br>
                    <span class="text-blue-600 relative">
                        Smart Prices.
                        <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 300 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 10C50 4 100 2 150 4C200 6 250 8 298 4" stroke="#BFDBFE" stroke-width="3" stroke-linecap="round"/>
                        </svg>
                    </span>
                </h1>

                <p class="text-lg text-gray-500 leading-relaxed mb-10 max-w-lg">
                    Experience the device you've always wanted at a fraction of the cost. Every phone passes a rigorous 90-point inspection and comes with a 12-month warranty.
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('products.index') }}"
                       class="btn-ripple inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-4 rounded-2xl transition-all duration-300 shadow-xl shadow-blue-600/30 hover:shadow-blue-600/50 hover:scale-105 active:scale-95">
                        Shop Collection
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="#"
                       class="inline-flex items-center gap-2 bg-white border-2 border-gray-100 text-gray-700 font-bold px-8 py-4 rounded-2xl hover:border-gray-200 hover:bg-gray-50 transition-all duration-300 hover:scale-105 active:scale-95">
                        View Grading Guide
                    </a>
                </div>

                <!-- Stats -->
                <div class="flex gap-10 mt-14 pt-10 border-t border-gray-100">
                    <div>
                        <p class="text-3xl font-black text-gray-900">500+</p>
                        <p class="text-sm text-gray-500 mt-1">Devices in stock</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-gray-900">12mo</p>
                        <p class="text-sm text-gray-500 mt-1">Warranty included</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-gray-900">4.9★</p>
                        <p class="text-sm text-gray-500 mt-1">Customer rating</p>
                    </div>
                </div>
            </div>

            <!-- Right: Hero Image -->
            <div class="relative fade-in-section delay-200 hidden lg:block">
                <div class="relative">
                    <!-- Floating card 1 -->
                    <div class="absolute -top-6 -left-6 bg-white rounded-2xl shadow-xl p-4 flex items-center gap-3 z-10 animate-bounce" style="animation-duration: 3s;">
                        <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-900">90-Point Check</p>
                            <p class="text-[10px] text-gray-400">Quality Certified</p>
                        </div>
                    </div>

                    <!-- Floating card 2 -->
                    <div class="absolute -bottom-4 -right-4 bg-white rounded-2xl shadow-xl p-4 flex items-center gap-3 z-10 animate-bounce" style="animation-duration: 4s; animation-delay: 1s;">
                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-900">30-Day Returns</p>
                            <p class="text-[10px] text-gray-400">Hassle-free</p>
                        </div>
                    </div>

                    <!-- Main image -->
                    <div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 rounded-3xl p-8 shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1616348436168-de43ad0db179?auto=format&fit=crop&q=80&w=800"
                             alt="Premium iPhone"
                             class="w-full h-[420px] object-cover rounded-2xl shadow-lg">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Top Selling Brands -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 fade-in-section">
    <h2 class="text-3xl font-black text-gray-900 mb-10">Top Selling Brands</h2>
    
    <div class="relative group overflow-hidden">
        <!-- Scroll Container -->
        <div class="flex gap-6 pb-8 w-max animate-marquee hover:[animation-play-state:paused]" id="brands-scroll">
            @foreach($brands as $brand)
                <a href="{{ route('products.index', ['brand' => $brand->slug]) }}" 
                   class="flex-none w-48 h-48 bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-xl hover:shadow-blue-900/5 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center p-6 gap-4 group/card relative overflow-hidden">
                    
                    <!-- Hover Effect Background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-white opacity-0 group-hover/card:opacity-100 transition-opacity"></div>
                    
                    <div class="relative z-10 flex flex-col items-center gap-4">
                        <img src="{{ $brand->logo_url }}" 
                                 alt="{{ $brand->name }}" class="h-16 w-auto object-contain transition-transform group-hover/card:scale-110 filter grayscale group-hover/card:grayscale-0 opacity-70 group-hover/card:opacity-100">
                        <span class="text-lg font-bold text-gray-500 group-hover/card:text-gray-900 transition-colors">{{ $brand->name }}</span>
                    </div>
                </a>
            @endforeach
            <!-- Duplicate for endless scroll -->
            @foreach($brands as $brand)
                <a href="{{ route('products.index', ['brand' => $brand->slug]) }}" 
                   class="flex-none w-48 h-48 bg-white border border-gray-100 rounded-2xl shadow-sm hover:shadow-xl hover:shadow-blue-900/5 hover:-translate-y-1 transition-all duration-300 flex flex-col items-center justify-center p-6 gap-4 group/card relative overflow-hidden" aria-hidden="true">
                    
                    <!-- Hover Effect Background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-white opacity-0 group-hover/card:opacity-100 transition-opacity"></div>
                    
                    <div class="relative z-10 flex flex-col items-center gap-4">
                        <img src="{{ $brand->logo_url }}" 
                                 alt="{{ $brand->name }}" class="h-16 w-auto object-contain transition-transform group-hover/card:scale-110 filter grayscale group-hover/card:grayscale-0 opacity-70 group-hover/card:opacity-100">
                        <span class="text-lg font-bold text-gray-500 group-hover/card:text-gray-900 transition-colors">{{ $brand->name }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<style>
@keyframes marquee {
    0% { transform: translateX(0); }
    100% { transform: translateX(calc(-50% - 12px)); }
}
.animate-marquee {
    animation: marquee 30s linear infinite;
}
.hide-scrollbar::-webkit-scrollbar {
    display: none;
}
.hide-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>

<!-- Featured Products -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
    <div class="flex items-end justify-between mb-12 fade-in-section">
        <div>
            <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-2">Handpicked for you</p>
            <h2 class="text-4xl font-black text-gray-900">Trending Now</h2>
        </div>
        <a href="{{ route('products.index') }}" class="hidden sm:inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors group">
            View All
            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($featuredProducts as $product)
            <div class="fade-in-section" style="transition-delay: {{ $loop->iteration * 80 }}ms">
                <x-product-card :product="$product" />
            </div>
        @endforeach
    </div>

    <div class="text-center mt-10 sm:hidden">
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors">
            View All Products →
        </a>
    </div>
</section>

<!-- Why Us / Features -->
<section class="bg-[#EFF7F6] py-20 fade-in-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-12">Why Us</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-12 gap-y-12">
            <!-- Item 1 -->
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-10 h-10 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Best Prices</h3>
                    <p class="text-sm text-gray-500">Objective AI-based pricing</p>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-10 h-10 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Instant Payment</h3>
                    <p class="text-sm text-gray-500">Instant Money Transfer in your preferred mode at time of pick up or store drop off</p>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-10 h-10 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Simple & Convenient</h3>
                    <p class="text-sm text-gray-500">Check price, schedule pickup & get paid</p>
                </div>
            </div>

            <!-- Item 4 -->
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-10 h-10 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Free Doorstep Pickup</h3>
                    <p class="text-sm text-gray-500">No fees for pickup across 1500 cities across India</p>
                </div>
            </div>

            <!-- Item 5 -->
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-10 h-10 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Factory Grade Data Wipe</h3>
                    <p class="text-sm text-gray-500">100% Safe and Data Security Guaranteed</p>
                </div>
            </div>

            <!-- Item 6 -->
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-10 h-10 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 mb-1">Valid Purchase Invoice</h3>
                    <p class="text-sm text-gray-500">Genuine Bill of Sale</p>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- CTA Banner -->
<section class="bg-[#76D2DB] py-20 fade-in-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-black text-white mb-4">Ready to upgrade?</h2>
        <p class="text-blue-100 text-lg mb-10 max-w-xl mx-auto">Browse our full collection of certified refurbished smartphones and find your perfect device today.</p>
        <a href="{{ route('products.index') }}"
           class="btn-ripple inline-flex items-center gap-2 bg-white text-blue-600 font-bold px-10 py-4 rounded-2xl hover:bg-blue-50 transition-all duration-300 shadow-xl hover:scale-105 active:scale-95">
            Browse All Phones
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</section>

@endsection