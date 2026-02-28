@extends('layouts.admin')

@section('title', 'Order ' . $order->order_number . ' - Admin Dashboard')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Order {{ $order->order_number }}</h1>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-600 hover:text-gray-900">← Back to Orders</a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Details & Items -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Items</h2>
                    <div class="space-y-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center justify-between py-4 border-b border-gray-100 last:border-0">
                            <div class="flex items-center">
                                <div class="h-16 w-16 bg-gray-100 rounded-md flex items-center justify-center text-2xl flex-shrink-0">
                                    @if($item->product && $item->product->primary_image_url)
                                        <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product->title }}" class="h-full w-full object-cover object-center rounded-md">
                                    @else
                                        📱
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $item->phone_title ?? $item->product?->title ?? 'Product' }}</h3>
                                    <p class="text-sm text-gray-500">{{ $item->storage }} | {{ $item->color }} | {{ $item->condition }}</p>
                                    <p class="text-xs text-gray-400">SKU: {{ $item->product?->sku ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">₹{{ number_format($item->price, 0) }}</p>
                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h2>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Subtotal</span>
                            <span>₹{{ number_format($order->total, 0) }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                        <div class="border-t border-gray-200 pt-2 flex justify-between font-bold text-gray-900">
                            <span>Total</span>
                            <span>₹{{ number_format($order->total, 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer & Status -->
            <div class="space-y-6">
                <!-- Status Update -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Update Status</h2>
                    <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Order Status</label>
                            <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm rounded-md">
                                @foreach(['pending', 'processing', 'shipped', 'delivered', 'cancelled'] as $status)
                                    <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800 border border-transparent">
                            Update Status
                        </button>
                    </form>
                </div>

                <!-- Customer Info -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Customer Details</h2>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Name</p>
                            <p class="text-sm text-gray-900">{{ $order->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="text-sm text-gray-900">{{ $order->user->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Member Since</p>
                            <p class="text-sm text-gray-900">{{ $order->user->created_at->format('M Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Shipping Address</h2>
                    <address class="text-sm text-gray-600 not-italic">
                        <span class="font-medium text-gray-900">{{ $order->address->label }}</span><br>
                        {{ $order->address->address_line1 }}<br>
                        @if($order->address->address_line2)
                            {{ $order->address->address_line2 }}<br>
                        @endif
                        {{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->postal_code }}<br>
                        {{ $order->address->country }}<br>
                        <span class="mt-2 block">📞 {{ $order->address->phone }}</span>
                    </address>
                </div>

                <!-- Payment Info -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment Info</h2>
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Method</span>
                            <span class="text-gray-900 font-medium">{{ strtoupper($order->payment->payment_method ?? 'N/A') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Status</span>
                            <span class="text-gray-900 font-medium">{{ ucwords(str_replace('_', ' ', $order->payment->status ?? 'pending')) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Transaction ID</span>
                            <span class="text-gray-900 font-medium text-xs">{{ $order->payment->transaction_id ?? '-' }}</span>
                        </div>
                        
                        @if($order->payment && $order->payment->payment_details)
                            <div class="pt-3 mt-3 border-t border-gray-100 space-y-2">
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">PayU Details</p>
                                
                                @php
                                    $details = $order->payment->payment_details;
                                    $isCard = in_array(strtoupper($details['mode'] ?? ''), ['CC', 'DC']);
                                    
                                    // ULTRA-GREEDY brand search
                                    $allStrings = strtoupper(implode(' ', array_filter(array_values($details ?? []))));
                                    
                                    $brand = 'Unknown';
                                    if (str_contains($allStrings, 'VISA')) $brand = 'VISA';
                                    elseif (str_contains($allStrings, 'MAST') || str_contains($allStrings, 'MASTER')) $brand = 'MASTERCARD';
                                    elseif (str_contains($allStrings, 'RUPAY')) $brand = 'RUPAY';
                                    elseif (str_contains($allStrings, 'AMEX') || str_contains($allStrings, 'AMERICAN')) $brand = 'AMEX';
                                    elseif (str_contains($allStrings, 'DINER')) $brand = 'DINERS';
                                    elseif (str_contains($allStrings, 'MAES')) $brand = 'MAESTRO';
                                    else {
                                        // BIN Detection (e.g. 4xxxxx = VISA, 5xxxxx = Mastercard)
                                        foreach($details as $k => $v) {
                                            if (is_string($v) && preg_match('/^[0-9]{6,16}/', $v)) {
                                                if (str_starts_with($v, '4')) { $brand = 'VISA'; break; }
                                                if (preg_match('/^5[1-5]/', $v)) { $brand = 'MASTERCARD'; break; }
                                            }
                                        }
                                        
                                        if ($brand === 'Unknown') {
                                            $brand = collect([$details['network_type'] ?? null, $details['card_type'] ?? null, $details['pg_type'] ?? null, $details['bankcode'] ?? null])
                                                    ->first(fn($val) => !empty($val)) ?? 'Unknown';
                                        }
                                    }
                                @endphp

                                @if(isset($details['mode']))
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Mode</span>
                                    <span class="text-gray-900 font-medium">{{ strtoupper($details['mode']) }}</span>
                                </div>
                                @endif

                                @if($isCard)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Card Network</span>
                                    <span class="text-gray-900 font-bold text-blue-600">{{ strtoupper($brand) }}</span>
                                </div>
                                @endif

                                @if(isset($details['bankcode']) && !empty($details['bankcode']))
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">{{ $isCard ? 'Network Code' : 'Bank Code' }}</span>
                                    <span class="text-gray-900 font-medium">{{ $details['bankcode'] }}</span>
                                </div>
                                @endif
                                
                                @if(!$isCard && isset($details['issuing_bank']) && !empty($details['issuing_bank']))
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Issuing Bank</span>
                                    <span class="text-gray-900 font-medium">{{ $details['issuing_bank'] }}</span>
                                </div>
                                @endif

                                @if(isset($details['upi_va']))
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">UPI VPA</span>
                                    <span class="text-gray-900 font-medium">{{ $details['upi_va'] }}</span>
                                </div>
                                @endif
                            </div>
                        @endif
                    </div>


                </div>

                @if($order->payment && $order->payment->payment_method === 'cod' && $order->payment->status === 'pending')
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <form action="{{ route('admin.orders.mark-payment-received', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2.5 rounded-lg text-xs font-bold hover:bg-blue-700 transition-colors flex items-center justify-center gap-2 shadow-sm shadow-blue-600/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Mark COD Payment Received
                            </button>
                        </form>
                        <p class="text-[10px] text-gray-400 mt-2 text-center">This will mark the order as Paid.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
