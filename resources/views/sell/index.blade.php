@extends('layouts.app')

@section('title', 'Sell Your Phone — PhoneShop')

@section('content')
<div class="bg-[#F0FAFE] min-h-screen pt-24 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-[#232A39] rounded-3xl overflow-hidden shadow-2xl">
            <div class="grid lg:grid-cols-2 gap-0">
                <!-- Left: Content -->
                <div class="p-12 lg:p-16">
                    <span class="inline-flex items-center gap-2 bg-blue-600/20 text-blue-400 text-xs font-bold uppercase tracking-widest px-4 py-2 rounded-full mb-8">
                        <span class="w-2 h-2 bg-blue-400 rounded-full"></span>
                        Sell & Trade-In
                    </span>
                    <h1 class="text-4xl font-black text-white leading-tight mb-6">
                        Got an old phone?<br>
                        <span class="text-blue-400">Turn it into cash.</span>
                    </h1>
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
                <div class="bg-[#283142] p-12 lg:p-16 flex flex-col justify-center">
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
        
        <!-- FAQ Section -->
        <div class="mt-16 max-w-3xl mx-auto">
            <h2 class="text-2xl font-black text-gray-900 mb-8 text-center">Frequently Asked Questions</h2>
            <div class="space-y-4">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-2">Do you accept broken phones?</h3>
                    <p class="text-gray-600 text-sm">Yes! We buy phones in any condition. Even if it's broken, water damaged, or won't turn on, we'll still give you a fair quote.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-2">How do I get paid?</h3>
                    <p class="text-gray-600 text-sm">We transfer the money directly to your verified bank account or UPI ID instantly after our agent inspects and picks up your device.</p>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-2">Is the pickup really free?</h3>
                    <p class="text-gray-600 text-sm">Absolutely. Our agent will come to your doorstep at a time convenient for you to inspect and collect the device. No hidden charges.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
