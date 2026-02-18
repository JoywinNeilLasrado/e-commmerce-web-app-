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

<!-- Brand Bar -->
<section class="border-y border-gray-100 py-10 bg-gray-50/50 fade-in-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-xs font-bold text-gray-400 uppercase tracking-widest mb-8">Trusted brands we carry</p>
        <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16">
            @foreach($brands as $brand)
                <a href="{{ route('products.index', ['brand' => $brand->slug]) }}"
                   class="text-lg font-black text-gray-300 hover:text-gray-700 transition-all duration-300 hover:scale-110">
                    {{ $brand->name }}
                </a>
            @endforeach
        </div>
    </div>
</section>

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
<section class="bg-gray-950 py-24 fade-in-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <p class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-3">Why PhoneShop</p>
            <h2 class="text-4xl font-black text-white">Built on trust.</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 hover:border-blue-800 hover:bg-gray-800/50 transition-all duration-300 group fade-in-section delay-100">
                <div class="w-12 h-12 bg-blue-600/20 rounded-xl flex items-center justify-center mb-6 group-hover:bg-blue-600/30 transition-colors">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">12-Month Warranty</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Full coverage for any technical defaults. If it's not working as it should, we'll fix or replace it — no questions asked.</p>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 hover:border-blue-800 hover:bg-gray-800/50 transition-all duration-300 group fade-in-section delay-200">
                <div class="w-12 h-12 bg-emerald-600/20 rounded-xl flex items-center justify-center mb-6 group-hover:bg-emerald-600/30 transition-colors">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">30-Day Returns</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Not impressed? Return the phone within 30 days for a full refund. We make it completely hassle-free.</p>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8 hover:border-blue-800 hover:bg-gray-800/50 transition-all duration-300 group fade-in-section delay-300">
                <div class="w-12 h-12 bg-purple-600/20 rounded-xl flex items-center justify-center mb-6 group-hover:bg-purple-600/30 transition-colors">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-3">90-Point Inspection</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Every component is rigorously tested — from battery life to screen quality. We ensure it performs like new.</p>
            </div>
        </div>
    </div>
</section>

<!-- Sell Your Phone -->
<section id="sell" class="py-24 bg-white fade-in-section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-gray-900 to-gray-800 rounded-3xl overflow-hidden">
            <div class="grid lg:grid-cols-2 gap-0">
                <!-- Left: Content -->
                <div class="p-12 lg:p-16">
                    <span class="inline-flex items-center gap-2 bg-blue-600/20 text-blue-400 text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full mb-8">
                        <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                        Sell &amp; Trade-In
                    </span>
                    <h2 class="text-4xl font-black text-white leading-tight mb-6">
                        Got an old phone?<br>
                        <span class="text-blue-400">Turn it into cash.</span>
                    </h2>
                    <p class="text-gray-400 text-lg leading-relaxed mb-10">
                        Get the best price for your used smartphone. We offer instant quotes, free pickup, and same-day payment. No hassle, no waiting.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="mailto:sell@phoneshop.com"
                           class="btn-ripple inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-500 text-white font-bold px-8 py-4 rounded-2xl transition-all duration-300 shadow-xl shadow-blue-600/30 hover:scale-105 active:scale-95">
                            Get an Instant Quote
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                    <div class="grid grid-cols-3 gap-6 mt-12 pt-10 border-t border-gray-700">
                        <div>
                            <p class="text-2xl font-black text-white">Free</p>
                            <p class="text-sm text-gray-500 mt-1">Pickup</p>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-white">Same</p>
                            <p class="text-sm text-gray-500 mt-1">Day payment</p>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-white">Best</p>
                            <p class="text-sm text-gray-500 mt-1">Price guaranteed</p>
                        </div>
                    </div>
                </div>
                <!-- Right: Steps -->
                <div class="bg-gray-800/50 p-12 lg:p-16 flex flex-col justify-center">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-8">How it works</p>
                    <div class="space-y-8">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 text-white font-black text-sm">1</div>
                            <div>
                                <h4 class="text-white font-bold mb-1">Tell us about your phone</h4>
                                <p class="text-gray-400 text-sm">Share the model, storage, and condition. Takes less than 2 minutes.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 text-white font-black text-sm">2</div>
                            <div>
                                <h4 class="text-white font-bold mb-1">Get an instant quote</h4>
                                <p class="text-gray-400 text-sm">We'll give you the best market price — no negotiations needed.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 text-white font-black text-sm">3</div>
                            <div>
                                <h4 class="text-white font-bold mb-1">Get paid instantly</h4>
                                <p class="text-gray-400 text-sm">Free pickup from your doorstep and same-day bank transfer.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Banner -->
<section class="bg-blue-600 py-20 fade-in-section">
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