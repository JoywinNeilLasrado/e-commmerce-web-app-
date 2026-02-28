@extends('layouts.app')

@section('title', 'My Orders — PhoneShop')

@section('content')
<div class="bg-gray-50 min-h-screen pt-24 pb-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex items-center justify-between mb-8 fade-in-section">
            <div>
                <h1 class="text-3xl font-black text-gray-900">My Orders</h1>
                <p class="text-sm text-gray-500 mt-1">{{ $orders->total() }} orders placed</p>
            </div>
        </div>

        @if($orders->count() > 0)
            <div class="space-y-5">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden fade-in-section" style="transition-delay: {{ $loop->iteration * 60 }}ms">

                        <!-- Order Header -->
                        <div class="flex flex-wrap items-center justify-between gap-4 px-6 py-4 bg-gray-50/80 border-b border-gray-100">
                            <div class="flex flex-wrap gap-6">
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Order</p>
                                    <p class="text-sm font-black text-blue-600 mt-0.5">#{{ $order->order_number }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Date</p>
                                    <p class="text-sm font-semibold text-gray-900 mt-0.5">{{ $order->created_at->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Total</p>
                                    <p class="text-sm font-black text-gray-900 mt-0.5">₹{{ number_format($order->total, 0) }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                @php
                                    $statusConfig = [
                                        'pending'    => ['bg-amber-100 text-amber-700', 'Pending'],
                                        'processing' => ['bg-blue-100 text-blue-700', 'Processing'],
                                        'shipped'    => ['bg-purple-100 text-purple-700', 'Shipped'],
                                        'delivered'  => ['bg-emerald-100 text-emerald-700', 'Delivered'],
                                        'cancelled'  => ['bg-red-100 text-red-700', 'Cancelled'],
                                    ];
                                    $config = $statusConfig[$order->status] ?? ['bg-gray-100 text-gray-700', ucfirst($order->status)];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold {{ $config[0] }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-current opacity-70"></span>
                                    {{ $config[1] }}
                                </span>
                                <a href="{{ route('orders.show', $order) }}"
                                   class="text-xs font-bold text-blue-600 hover:text-blue-700 border border-blue-200 hover:border-blue-300 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition-all">
                                    View Details
                                </a>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="px-6 py-5 divide-y divide-gray-50">
                            @foreach($order->items as $item)
                                <div class="flex items-center gap-4 py-4 first:pt-0 last:pb-0">
                                    <div class="w-14 h-14 flex-shrink-0 bg-gray-50 rounded-xl border border-gray-100 overflow-hidden flex items-center justify-center p-1.5">
                                        <img src="{{ $item->product?->primary_image_url ?? asset('images/placeholder.png') }}"
                                             alt="{{ $item->phone_title ?? $item->product?->title }}"
                                             class="w-full h-full object-contain">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-bold text-gray-900 truncate">{{ $item->phone_title ?? $item->product?->title }}</h4>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="text-[10px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">{{ $item->storage ?? $item->product?->storage }}</span>
                                            <span class="text-[10px] font-bold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">{{ $item->color ?? $item->product?->color }}</span>
                                            <span class="text-[10px] text-gray-400">Qty: {{ $item->quantity }}</span>
                                        </div>
                                    </div>
                                    <p class="text-sm font-black text-gray-900 flex-shrink-0">₹{{ number_format($item->price * $item->quantity, 0) }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-28 bg-white rounded-3xl border border-gray-100 shadow-sm fade-in-section">
                <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <h2 class="text-2xl font-black text-gray-900 mb-3">No orders yet</h2>
                <p class="text-gray-500 mb-10">Ready to find your next favorite device?</p>
                <a href="{{ route('products.index') }}"
                   class="btn-ripple inline-flex items-center gap-2 bg-blue-600 text-white font-bold px-10 py-4 rounded-2xl hover:bg-blue-700 transition-all shadow-xl shadow-blue-600/25 hover:scale-105 active:scale-95">
                    Browse Phones
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
