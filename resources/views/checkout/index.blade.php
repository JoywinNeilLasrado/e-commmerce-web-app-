@extends('layouts.app')

@section('title', 'Checkout - Refurbished Phones Shop')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">Checkout</h1>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Address & Payment -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Delivery Address -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-xl font-bold text-gray-900">1. Delivery Address</h2>
                            <button type="button" onclick="document.getElementById('new-address-form').classList.toggle('hidden')" 
                                    class="text-xs font-bold text-indigo-600 hover:text-indigo-700 uppercase tracking-widest border border-indigo-100 px-3 py-1 rounded-full transition-all">
                                + Add New
                            </button>
                        </div>
                        
                        @if($addresses->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                @foreach($addresses as $address)
                                    <label class="relative border-2 border-gray-100 rounded-xl p-4 cursor-pointer hover:border-indigo-600/50 transition-all focus-within:ring-2 focus-within:ring-indigo-600">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="address-{{ $address->id }}" name="address_id" type="radio" value="{{ $address->id }}" 
                                                       {{ $loop->first ? 'checked' : '' }}
                                                       class="focus:ring-indigo-600 h-4 w-4 text-indigo-600 border-gray-300">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <span class="block font-bold text-gray-900 uppercase tracking-tight">{{ $address->full_name }}</span>
                                                <span class="block text-gray-500 mt-1 leading-relaxed">
                                                    {{ $address->address_line1 }}<br>
                                                    @if($address->address_line2) {{ $address->address_line2 }}<br> @endif
                                                    {{ $address->city }}, {{ $address->state }} {{ $address->pincode }}
                                                </span>
                                                <span class="block text-gray-900 font-medium mt-2">📞 {{ $address->phone }}</span>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                           <p class="text-sm text-gray-500 mb-4 bg-gray-50 p-4 rounded-lg italic">No saved addresses found. Please add a new delivery address below.</p>
                        @endif

                        <!-- New Address Form (Hidden by default if addresses exist) -->
                        <div id="new-address-form" class="{{ $addresses->count() > 0 ? 'hidden' : '' }} mt-6 pt-6 border-t border-gray-100">
                             <!-- This would normally be handled by a sub-component or separate page in a robust app -->
                             <p class="text-xs text-gray-400 mb-4 underline">Fill in details for a new delivery address:</p>
                             <div class="grid grid-cols-2 gap-4">
                                <a href="{{ route('profile.edit') }}" class="col-span-2 text-center py-3 bg-gray-50 text-indigo-600 font-bold rounded-lg hover:bg-indigo-50 transition-all">Manage Addresses in Profile →</a>
                             </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">2. Payment Method</h2>
                        
                        <div class="space-y-4">
                            <label class="flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition-all">
                                <input name="payment_method" type="radio" value="Card" checked class="focus:ring-indigo-600 h-4 w-4 text-indigo-600 border-gray-300">
                                <span class="ml-3 block text-sm font-bold text-gray-700">Credit/Debit Card (Simulated)</span>
                                <span class="ml-auto text-2xl grayscale opacity-50">💳</span>
                            </label>
                            <label class="flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition-all">
                                <input name="payment_method" type="radio" value="UPI" class="focus:ring-indigo-600 h-4 w-4 text-indigo-600 border-gray-300">
                                <span class="ml-3 block text-sm font-bold text-gray-700">UPI (Simulated)</span>
                                <span class="ml-auto text-2xl grayscale opacity-50">📱</span>
                            </label>
                            <label class="flex items-center p-4 border rounded-xl cursor-pointer hover:bg-gray-50 transition-all">
                                <input name="payment_method" type="radio" value="COD" class="focus:ring-indigo-600 h-4 w-4 text-indigo-600 border-gray-300">
                                <span class="ml-3 block text-sm font-bold text-gray-700">Cash on Delivery</span>
                                <span class="ml-auto text-2xl grayscale opacity-50">💵</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 sticky top-24">
                        <h2 class="text-lg font-bold text-gray-900 mb-6 uppercase tracking-wider border-b pb-2">Your Order</h2>
                        
                        <ul class="divide-y divide-gray-100 mb-6 max-h-60 overflow-y-auto no-scrollbar">
                            @foreach($cart->items as $item)
                                <li class="py-4 flex justify-between text-sm">
                                    <div class="flex flex-col">
                                        <span class="text-gray-900 font-bold">{{ $item->variant->product->title }}</span>
                                        <span class="text-gray-500 text-xs">{{ $item->quantity }}x | {{ $item->variant->storage }}</span>
                                    </div>
                                    <span class="font-bold text-indigo-600">₹{{ number_format($item->price * $item->quantity, 0) }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="border-t-2 border-indigo-50 pt-6 space-y-4">
                            <div class="flex justify-between text-sm">
                                <dt class="text-gray-500">Subtotal</dt>
                                <dd class="font-bold text-gray-900">₹{{ number_format($cart->items->sum(fn($i) => $i->price * $i->quantity), 0) }}</dd>
                            </div>
                            <div class="flex justify-between text-sm">
                                <dt class="text-gray-500">Shipping</dt>
                                <dd class="font-bold text-green-600">Free</dd>
                            </div>
                            <div class="flex justify-between pt-4 border-t border-gray-100">
                                <dt class="text-lg font-extrabold text-gray-900">Total</dt>
                                <dd class="text-2xl font-black text-indigo-600">₹{{ number_format($cart->items->sum(fn($i) => $i->price * $i->quantity), 0) }}</dd>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 border border-transparent rounded-lg shadow-lg shadow-indigo-600/20 py-4 px-4 text-lg font-bold text-white hover:bg-indigo-700 mt-8 transform active:scale-[0.98] transition-all">
                            Place Order
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>
@endsection
