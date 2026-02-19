@extends('layouts.app')

@section('title', 'Shopping Cart — PhoneShop')

@section('content')
<div class="bg-gray-50 min-h-screen pt-24 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <h1 class="text-3xl font-black text-gray-900 mb-8 fade-in-section">Shopping Cart</h1>

        @if($cart && $cart->items->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Cart Items -->
                <div class="lg:col-span-2 space-y-4 fade-in-section">
                    @foreach($cart->items as $item)
                        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow duration-300">
                            <div class="flex gap-5">
                                <!-- Product Image -->
                                <div class="w-24 h-24 flex-shrink-0 bg-gray-50 rounded-xl overflow-hidden border border-gray-100 flex items-center justify-center p-2">
                                    <img src="{{ $item->productVariant->product->primary_image_url }}"
                                         alt="{{ $item->productVariant->product->title }}"
                                         class="w-full h-full object-contain">
                                </div>

                                <!-- Product Details -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-4">
                                        <div>
                                            <h3 class="font-bold text-gray-900 text-sm leading-snug">
                                                <a href="{{ route('products.show', $item->productVariant->product) }}" class="hover:text-blue-600 transition-colors">
                                                    {{ $item->productVariant->product->title }}
                                                </a>
                                            </h3>
                                            <div class="flex flex-wrap gap-2 mt-2">
                                                <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">{{ $item->productVariant->storage }}</span>
                                                <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">{{ $item->productVariant->color }}</span>
                                                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full">{{ $item->productVariant->condition->name }}</span>
                                            </div>
                                        </div>
                                        <p class="text-lg font-black text-gray-900 flex-shrink-0">₹{{ number_format($item->price * $item->quantity, 0) }}</p>
                                    </div>

                                    <div class="flex items-center justify-between mt-4">
                                        <!-- Quantity -->
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <label class="text-xs font-bold text-gray-400 uppercase tracking-wider">Qty:</label>
                                            <select name="quantity" onchange="this.form.submit()"
                                                    class="border border-gray-200 rounded-lg py-1.5 px-3 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 bg-gray-50">
                                                @for($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </form>

                                        <!-- Remove -->
                                        <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex items-center gap-1.5 text-xs font-medium text-red-400 hover:text-red-600 hover:bg-red-50 px-3 py-1.5 rounded-lg transition-all">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Continue Shopping -->
                    <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors mt-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                        Continue Shopping
                    </a>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1 fade-in-section delay-100">
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm sticky top-28">
                        <h2 class="text-lg font-black text-gray-900 mb-6">Order Summary</h2>

                        <div class="space-y-4 mb-6">
                            @foreach($cart->items as $item)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600 truncate flex-1 mr-4">{{ $item->productVariant->product->title }} <span class="text-gray-400">×{{ $item->quantity }}</span></span>
                                    <span class="font-semibold text-gray-900 flex-shrink-0">₹{{ number_format($item->price * $item->quantity, 0) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-gray-100 pt-4 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Subtotal</span>
                                <span class="font-semibold text-gray-900">₹{{ number_format($cart->items->sum(fn($i) => $i->price * $i->quantity), 0) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Shipping</span>
                                <span class="font-bold text-emerald-600">Free</span>
                            </div>
                            <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                <span class="text-base font-black text-gray-900">Total</span>
                                <span class="text-2xl font-black text-blue-600">₹{{ number_format($cart->items->sum(fn($i) => $i->price * $i->quantity), 0) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}"
                           class="btn-ripple mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl transition-all duration-200 shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50 hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center gap-2">
                            Proceed to Checkout
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>

                        <div class="mt-4 flex items-center justify-center gap-4 text-xs text-gray-400">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                Secure checkout
                            </span>
                            <span>·</span>
                            <span>Free returns</span>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-28 bg-white rounded-3xl border border-gray-100 shadow-sm fade-in-section">
                <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <h2 class="text-2xl font-black text-gray-900 mb-3">Your cart is empty</h2>
                <p class="text-gray-500 mb-10">Looks like you haven't added any phones yet.</p>
                <a href="{{ route('products.index') }}"
                   class="btn-ripple inline-flex items-center gap-2 bg-blue-600 text-white font-bold px-10 py-4 rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-600/25 hover:scale-105 active:scale-95">
                    Start Shopping
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
