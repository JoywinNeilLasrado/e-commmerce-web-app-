@extends('layouts.app')

@section('title', 'Shopping Cart — PhoneShop')

@section('content')
<div class="bg-gray-50 min-h-screen pt-24 pb-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex items-center justify-between mb-10 fade-in-section">
            <div class="flex items-center gap-4">
                <a href="{{ route('products.index') }}" class="p-2 text-gray-400 hover:text-gray-700 hover:bg-white rounded-xl border border-gray-200 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                </a>
                <div>
                    <h1 class="text-3xl font-black text-gray-900">Shopping Cart</h1>
                    <p class="text-sm text-gray-500 mt-0.5">{{ $cart->items->count() }} {{ Str::plural('item', $cart->items->count()) }}</p>
                </div>
            </div>
        </div>

        @if($cart->items->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-4 fade-in-section">
                    @foreach($cart->items as $item)
                        <div class="bg-white rounded-2xl border border-gray-100 p-6 hover:border-blue-200 transition-all group relative">
                            <div class="flex gap-5">
                                <!-- Image -->
                                <div class="w-24 h-24 flex-shrink-0 bg-gray-50 rounded-xl overflow-hidden border border-gray-100 flex items-center justify-center p-2">
                                    <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->title }}" class="w-full h-full object-contain">
                                </div>

                                <!-- Details -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="font-bold text-gray-900 text-sm group-hover:text-blue-600 transition-colors">
                                                <a href="{{ route('products.show', $item->product->slug) }}">{{ $item->product->title }}</a>
                                            </h3>
                                            <div class="flex items-center gap-2 mt-1.5 flex-wrap">
                                                @if($item->product->storage)
                                                    <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">{{ $item->product->storage }}</span>
                                                @endif
                                                @if($item->product->color)
                                                    <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-full">{{ $item->product->color }}</span>
                                                @endif
                                                @if($item->product->condition)
                                                    <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">{{ $item->product->condition->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <p class="text-lg font-black text-gray-900 ml-4 flex-shrink-0">₹{{ number_format($item->price * $item->quantity, 0) }}</p>
                                    </div>

                                    <!-- Quantity & Remove -->
                                    <div class="flex items-center justify-between mt-4">
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <div class="flex items-center rounded-xl border border-gray-200 bg-gray-50">
                                                <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}"
                                                        class="px-3 py-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-all rounded-l-xl">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/></svg>
                                                </button>
                                                <span class="w-10 text-center text-sm font-bold text-gray-900">{{ $item->quantity }}</span>
                                                <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}"
                                                        class="px-3 py-1.5 text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-all rounded-r-xl">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                                </button>
                                            </div>
                                        </form>

                                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-500 hover:text-red-700 font-bold flex items-center gap-1 transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1 fade-in-section delay-100">
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm sticky top-28">
                        <h2 class="text-lg font-black text-gray-900 mb-6">Order Summary</h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Subtotal ({{ $cart->items->count() }} items)</span>
                                <span class="font-semibold text-gray-900">₹{{ number_format($cart->items->sum(fn($i) => $i->price * $i->quantity), 0) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Shipping</span>
                                <span class="font-bold text-emerald-600">Free</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center py-4 border-t border-gray-100">
                            <span class="font-black text-gray-900">Total</span>
                            <span class="text-2xl font-black text-blue-600">₹{{ number_format($cart->items->sum(fn($i) => $i->price * $i->quantity), 0) }}</span>
                        </div>

                        <a href="{{ route('checkout.index') }}"
                           class="btn-ripple block w-full bg-blue-600 hover:bg-blue-700 text-white text-center font-bold py-4 rounded-2xl transition-all duration-200 shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50 mt-4 hover:scale-[1.02] active:scale-[0.98]">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-20 fade-in-section">
                <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-5 border border-gray-100">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-500 mb-8">Looks like you haven't added anything yet.</p>
                <a href="{{ route('products.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-2xl transition-all shadow-lg shadow-blue-600/30">
                    Explore Products
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
