@extends('layouts.app')

@section('title', 'Order #' . $order->order_number . ' - Refurbished Phones Shop')

@section('content')
<div class="bg-gray-50 min-h-screen pt-24 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <div>
                 <a href="{{ route('orders.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mb-2 inline-block">← Back to Orders</a>
                <h1 class="text-3xl font-bold text-gray-900">Order #{{ $order->order_number }}</h1>
                <p class="text-sm text-gray-500">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
            
            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg text-sm font-medium animate-pulse">
                    ✅ Order Placed Successfully!
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Details -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-6">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                         <h2 class="font-semibold text-gray-900">Items ({{ $order->items->count() }})</h2>
                         <span class="px-3 py-1 text-xs font-semibold rounded-full
                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                            @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                            @elseif($order->status == 'delivered') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <ul class="divide-y divide-gray-200">
                        @foreach($order->items as $item)
                            <li class="p-6 flex items-center">
                                <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 bg-gray-100 flex items-center justify-center">
                                    @if($item->productVariant->product->primary_image_url)
                                        <img src="{{ $item->productVariant->product->primary_image_url }}" alt="{{ $item->productVariant->product->title }}" class="h-full w-full object-cover object-center">
                                    @else
                                        <span class="text-3xl">📱</span>
                                    @endif
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex justify-between">
                                        <h3 class="text-base font-medium text-gray-900">
                                            <a href="{{ route('products.show', $item->productVariant->product->slug) }}">
                                                {{ $item->productVariant->product->title }}
                                            </a>
                                        </h3>
                                        <p class="ml-4 font-medium text-gray-900">₹{{ number_format($item->price * $item->quantity, 0) }}</p>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">
                                        {{ $item->productVariant->storage }} | {{ $item->productVariant->color }} | {{ $item->productVariant->condition->name }}
                                    </p>
                                    <p class="mt-1 text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Payment Info -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="font-semibold text-gray-900 mb-4">Payment Information</h2>
                    @if($order->payment)
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600 text-sm">Transaction ID</span>
                            <span class="text-gray-900 text-sm font-medium">{{ $order->payment->transaction_id }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600 text-sm">Payment Method</span>
                            <span class="text-gray-900 text-sm font-medium uppercase">{{ $order->payment->payment_method }}</span>
                        </div>
                         <div class="flex justify-between py-2 border-b border-gray-100">
                            <span class="text-gray-600 text-sm">Payment Status</span>
                            <span class="text-sm font-medium
                                {{ $order->payment->status == 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ ucfirst($order->payment->status) }}
                            </span>
                        </div>
                    @else
                         <p class="text-sm text-gray-500">No payment information available.</p>
                    @endif
                </div>
            </div>

            <!-- Shipping Address & Summary -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Shipping Address -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="font-semibold text-gray-900 mb-4">Shipping Address</h2>
                    <address class="not-italic text-sm text-gray-600">
                        <span class="block font-medium text-gray-900 mb-1">{{ $order->user->name }}</span>
                        @if($order->address)
                            {{ $order->address->address_line1 }}<br>
                            @if($order->address->address_line2) {{ $order->address->address_line2 }}<br> @endif
                            {{ $order->address->city }}, {{ $order->address->state }}<br>
                            {{ $order->address->postal_code }}<br>
                            Phone: {{ $order->address->phone }}
                        @else
                            <span class="text-red-500">Address deleted</span>
                        @endif
                    </address>
                </div>

                <!-- Order Totals -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="font-semibold text-gray-900 mb-4">Order Summary</h2>
                    <div class="flex justify-between py-2 text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium text-gray-900">₹{{ number_format($order->total, 0) }}</span>
                    </div>
                    <div class="flex justify-between py-2 text-sm border-b border-gray-100">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-medium text-green-600">Free</span>
                    </div>
                    <div class="flex justify-between py-4 text-base font-bold">
                        <span class="text-gray-900">Total</span>
                        <span class="text-gray-900">₹{{ number_format($order->total, 0) }}</span>
                    </div>
                </div>
                
                <div class="text-center">
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-500 font-medium">Download Invoice (Coming Soon)</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
