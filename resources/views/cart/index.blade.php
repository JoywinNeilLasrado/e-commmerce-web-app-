@extends('layouts.app')

@section('title', 'Shopping Cart - Refurbished Phones Shop')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

        @if($cart && $cart->items->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                        <ul class="divide-y divide-gray-200">
                            @foreach($cart->items as $item)
                                <li class="p-6 flex items-center">
                                    <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 bg-gray-100 flex items-center justify-center">
                                         <img src="{{ $item->variant->product->primary_image }}" class="w-full h-full object-contain">
                                    </div>

                                    <div class="ml-4 flex-1 flex flex-col text-sm">
                                        <div>
                                            <div class="flex justify-between text-base font-medium text-gray-900">
                                                <h3>
                                                    <a href="{{ route('products.show', $item->variant->product) }}" class="hover:text-indigo-600">
                                                        {{ $item->variant->product->title }}
                                                    </a>
                                                </h3>
                                                <p class="ml-4 font-bold">₹{{ number_format($item->price, 0) }}</p>
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ $item->variant->storage }} | {{ $item->variant->color }} | {{ $item->variant->condition->name }}
                                            </p>
                                        </div>
                                        <div class="flex-1 flex items-end justify-between text-sm">
                                            <div class="flex items-center">
                                                <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <label for="quantity-{{ $item->id }}" class="sr-only">Quantity</label>
                                                    <select id="quantity-{{ $item->id }}" name="quantity" onchange="this.form.submit()"
                                                            class="rounded-md border border-gray-300 text-xs font-medium text-gray-700 text-left shadow-sm focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                                        @for($i = 1; $i <= 10; $i++)
                                                            <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>
                                                                {{ $i }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </form>
                                            </div>

                                            <div class="flex">
                                                <form action="{{ route('cart.destroy', $item) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="font-medium text-red-600 hover:text-red-500 text-xs uppercase tracking-wider">Remove</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4 uppercase tracking-wider">Order Summary</h2>
                        
                        <div class="flow-root">
                            <dl class="-my-4 divide-y divide-gray-200">
                                <div class="py-4 flex items-center justify-between">
                                    <dt class="text-sm text-gray-600">Subtotal</dt>
                                    <dd class="text-sm font-medium text-gray-900">₹{{ number_format($cart->items->sum(fn($i) => $i->price * $i->quantity), 0) }}</dd>
                                </div>
                                <div class="py-4 flex items-center justify-between">
                                    <dt class="text-sm text-gray-600">Shipping</dt>
                                    <dd class="text-sm font-medium text-green-600">Free</dd>
                                </div>
                                <div class="py-4 flex items-center justify-between pt-6 border-t-2">
                                    <dt class="text-base font-bold text-gray-900">Order Total</dt>
                                    <dd class="text-xl font-extrabold text-indigo-600">₹{{ number_format($cart->items->sum(fn($i) => $i->price * $i->quantity), 0) }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="mt-8">
                            <a href="{{ route('checkout.index') }}" class="w-full bg-indigo-600 border border-transparent rounded-lg shadow-lg shadow-indigo-600/20 py-3 px-4 text-base font-bold text-white hover:bg-indigo-700 flex justify-center items-center transform active:scale-[0.98] transition-all">
                                Proceed to Checkout
                            </a>
                        </div>
                        <div class="mt-4 text-center">
                             <a href="{{ route('products.index') }}" class="text-sm text-gray-500 hover:text-indigo-600 font-medium transition-colors">
                                or Continue Shopping
                             </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-gray-100">
                <span class="text-6xl mb-4 block">🛒</span>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h2>
                <p class="text-gray-600 mb-8">Looks like you haven't added any phones to your cart yet.</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-indigo-600 text-white px-10 py-3 rounded-full font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-600/20 transition-all">
                    Start Shopping
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
