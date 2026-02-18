@extends('layouts.app')

@section('title', 'Premium Refurbished Phones - Refurbished Phones Shop')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative overflow-hidden bg-white pt-16 pb-32">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-8 items-center">
                <div class="sm:text-center md:max-w-2xl md:mx-auto lg:col-span-6 lg:text-left">
                    <h1 class="text-base font-bold text-indigo-600 uppercase tracking-widest mb-4">Certified Refurbished</h1>
                    <h2 class="mt-1 text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl lg:text-5xl xl:text-6xl">
                        <span class="block text-gray-900">Premium Tech.</span>
                        <span class="block text-indigo-600">Smart Prices.</span>
                    </h2>
                    <p class="mt-6 text-base text-gray-500 sm:text-xl lg:text-lg xl:text-xl leading-relaxed">
                        Experience the phone you've always wanted at a fraction of the cost. Every device undergoes a strict 90-point inspection and comes with a 1-year warranty.
                    </p>
                    <div class="mt-10 sm:flex sm:justify-center lg:justify-start gap-4">
                        <a href="{{ route('products.index') }}" class="flex items-center justify-center px-8 py-4 border border-transparent text-base font-bold rounded-full text-white bg-indigo-600 hover:bg-indigo-700 shadow-xl shadow-indigo-600/20 transform transition-all hover:scale-105 active:scale-95">
                            Shop Collection
                        </a>
                        <a href="#" class="flex items-center justify-center px-8 py-4 border-2 border-gray-100 text-base font-bold rounded-full text-gray-900 bg-white hover:bg-gray-50 shadow-sm transform transition-all hover:scale-105 active:scale-95">
                            Learn About Grading
                        </a>
                    </div>
                </div>
                <div class="mt-12 relative sm:max-w-lg sm:mx-auto lg:mt-0 lg:max-w-none lg:mx-0 lg:col-span-6 lg:flex lg:items-center">
                    <div class="relative mx-auto w-full rounded-3xl shadow-2xl overflow-hidden transform lg:rotate-3 rotate-0">
                        <img class="w-full" src="https://images.unsplash.com/photo-1616348436168-de43ad0db179?auto=format&fit=crop&q=80&w=1200" alt="iPhone 14 Pro">
                        <div class="absolute inset-0 bg-gradient-to-tr from-indigo-600/10 to-transparent pointer-events-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Brands -->
    <div class="bg-gray-50 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm font-bold text-gray-400 uppercase tracking-widest mb-8">Trust in the best brands</p>
            <div class="grid grid-cols-2 gap-8 md:grid-cols-5 lg:grid-cols-5 items-center justify-items-center opacity-50 grayscale">
                @foreach($brands as $brand)
                    <div class="text-xl font-bold text-gray-800">{{ $brand->name }}</div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Featured Products -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="flex items-end justify-between mb-12">
            <div>
                <h2 class="text-base font-bold text-indigo-600 uppercase tracking-widest">Trending Now</h2>
                <h3 class="mt-2 text-3xl font-extrabold text-gray-900">Featured Phones</h3>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-700 transition">View All Products →</a>
        </div>

        <div class="grid grid-cols-1 gap-y-12 gap-x-8 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($featuredProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>

    <!-- Why Us Section -->
    <div class="bg-indigo-600 py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center text-white">
                <div>
                    <div class="text-5xl mb-6">🛡️</div>
                    <h3 class="text-xl font-bold mb-4">12-Month Warranty</h3>
                    <p class="text-indigo-100 text-sm leading-relaxed">Full coverage for any technical defaults. If it's not working as it should, we'll fix/replace it.</p>
                </div>
                <div>
                    <div class="text-5xl mb-6">🔄</div>
                    <h3 class="text-xl font-bold mb-4">30-Day Money Back</h3>
                    <p class="text-indigo-100 text-sm leading-relaxed">Not impressed? Return the phone within 30 days for a full refund. No questions asked.</p>
                </div>
                <div>
                    <div class="text-5xl mb-6">✅</div>
                    <h3 class="text-xl font-bold mb-4">90-Point Inspection</h3>
                    <p class="text-indigo-100 text-sm leading-relaxed">Every component is tested. From battery life to screen quality, we ensure it's like new.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
