@extends('layouts.app')

@section('title', 'My Orders - Refurbished Phones Shop')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-extrabold text-gray-900 mb-8">My Orders</h1>

        @if($orders->count() > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="bg-gray-50 px-6 py-4 flex flex-wrap items-center justify-between border-b gap-4">
                            <div class="flex gap-8">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Order Number</p>
                                    <p class="text-sm font-bold text-indigo-600">#{{ $order->order_number }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Order Date</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total Amount</p>
                                    <p class="text-sm font-bold text-gray-900">₹{{ number_format($order->total, 0) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-widest rounded-full shadow-sm
                                    @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                    @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                    @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ $order->status }}
                                </span>
                                <a href="{{ route('orders.show', $order) }}" class="ml-6 text-sm font-bold text-indigo-600 hover:text-indigo-700 transition">View Details →</a>
                            </div>
                        </div>
                        
                        <div class="px-6 py-6 divide-y divide-gray-50">
                             @foreach($order->items as $item)
                                <div class="flex items-center py-4 first:pt-0 last:pb-0">
                                    <div class="h-16 w-16 flex-shrink-0 bg-gray-50 rounded-lg p-2 flex items-center justify-center border">
                                        <img src="{{ $item->variant->product->primary_image }}" class="w-full h-full object-contain">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h4 class="text-sm font-bold text-gray-900">{{ $item->variant->product->title }}</h4>
                                        <p class="text-xs text-gray-500 mt-0.5">{{ $item->variant->storage }} | {{ $item->variant->color }} | Qty: {{ $item->quantity }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-gray-900">₹{{ number_format($item->price * $item->quantity, 0) }}</p>
                                    </div>
                                </div>
                             @endforeach
                        </div>
                    </div>
                @endforeach
                
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-gray-100 italic">
                <span class="text-6xl mb-4 block">📦</span>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">You haven't placed any orders yet</h2>
                <p class="text-gray-600 mb-8">Ready to find your next favorite device?</p>
                <a href="{{ route('products.index') }}" class="inline-block bg-indigo-600 text-white px-10 py-3 rounded-full font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-600/20 transition-all">
                    Browse Phones
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
