@extends('layouts.app')

@section('title', 'Order #' . $order->order_number . ' - Refurbished Phones Shop')

@section('content')
<div class="bg-gray-50 min-h-screen pt-24 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-between items-center">
            <div>
                 <a href="{{ route('orders.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mb-2 inline-block">← Back to Orders</a>
                <div class="flex items-center gap-4">
                    <h1 class="text-3xl font-bold text-gray-900">Order #{{ $order->order_number }}</h1>
                    @if(in_array($order->status, ['pending', 'processing']))
                        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                            @csrf
                            <button type="submit" class="px-4 py-2 text-sm font-bold text-red-600 hover:text-white border-2 border-red-600 hover:bg-red-600 rounded-xl transition-all shadow-sm">
                                Cancel Order
                            </button>
                        </form>
                    @endif
                </div>
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
                                    <div class="flex justify-between items-center mt-1">
                                        <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                        <form action="{{ route('cart.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="variant_id" value="{{ $item->product_variant_id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="text-sm font-bold text-blue-600 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 px-4 py-2 rounded-xl transition-all flex items-center gap-2 shadow-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 118 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                                Buy Again
                                            </button>
                                        </form>
                                    </div>
                                    
                                    @php
                                        $userReview = $item->productVariant->product->reviews->where('user_id', auth()->id())->first();
                                    @endphp

                                    <div class="mt-4 border-t border-gray-100 pt-4">
                                        @if($userReview)
                                            <!-- View Review Mode -->
                                            <div id="view-review-{{ $item->id }}" class="bg-gray-50 rounded-xl p-4 border border-gray-100 relative group">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Your Rating</span>
                                                    <div class="flex">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <svg class="w-4 h-4 {{ $i <= $userReview->rating ? 'text-amber-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                </div>
                                                @if($userReview->comment)
                                                    <p class="text-sm text-gray-600">"{{ $userReview->comment }}"</p>
                                                @endif
                                                
                                                <button onclick="toggleOrderEdit('{{ $item->id }}')" class="absolute top-2 right-2 p-1.5 text-gray-400 hover:text-blue-600 hover:bg-white rounded-lg transition-all opacity-0 group-hover:opacity-100" title="Edit Review">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                </button>
                                            </div>

                                            <!-- Edit Review Mode (Hidden) -->
                                            <form id="edit-review-{{ $item->id }}" action="{{ route('reviews.update', $userReview->id) }}" method="POST" class="hidden bg-white rounded-xl p-4 border border-gray-200 shadow-sm relative">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="product_id" value="{{ $item->productVariant->product->id }}">
                                                
                                                <button type="button" onclick="toggleOrderEdit('{{ $item->id }}')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>

                                                <div class="mb-4">
                                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Edit Rating</label>
                                                    <div class="flex items-center gap-1 group/stars-{{ $item->id }}">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <button type="button" onclick="setOrderRating({{ $i }}, '{{ $item->id }}')" 
                                                                    class="star-btn-{{ $item->id }} transition-colors focus:outline-none {{ $i <= $userReview->rating ? 'text-amber-400' : 'text-gray-300' }} hover:text-amber-400 p-1" 
                                                                    data-rating="{{ $i }}">
                                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                </svg>
                                                            </button>
                                                        @endfor
                                                    </div>
                                                    <input type="hidden" name="rating" id="rating-input-{{ $item->id }}" value="{{ $userReview->rating }}" required>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Edit Review</label>
                                                    <textarea name="comment" rows="2" placeholder="Share your experience..."
                                                              class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500">{{ $userReview->comment }}</textarea>
                                                </div>
                                                
                                                <div class="text-right">
                                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg text-xs transition-all shadow-md shadow-blue-600/20">
                                                        Update
                                                    </button>
                                                </div>
                                            </form>
                                        @else
                                            <form action="{{ route('reviews.store') }}" method="POST" class="bg-white rounded-xl p-4 border border-gray-200 shadow-sm">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $item->productVariant->product->id }}">
                                                
                                                <div class="mb-4">
                                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Rating</label>
                                                    <div class="flex items-center gap-1 group/stars-{{ $item->id }}">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <button type="button" onclick="setOrderRating({{ $i }}, '{{ $item->id }}')" 
                                                                    class="star-btn-{{ $item->id }} transition-colors focus:outline-none text-gray-300 hover:text-amber-400 p-1" 
                                                                    data-rating="{{ $i }}">
                                                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                </svg>
                                                            </button>
                                                        @endfor
                                                    </div>
                                                    <input type="hidden" name="rating" id="rating-input-{{ $item->id }}" required>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Your Review <span class="text-gray-400 font-normal lowercase">(optional)</span></label>
                                                    <textarea name="comment" rows="2" placeholder="Share your experience..."
                                                              class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                                                </div>
                                                
                                                <div class="text-right">
                                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg text-xs transition-all shadow-md shadow-blue-600/20">
                                                        Submit Review
                                                    </button>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
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

<script>
    function toggleOrderEdit(itemId) {
        const viewMode = document.getElementById(`view-review-${itemId}`);
        const editMode = document.getElementById(`edit-review-${itemId}`);
        
        if (viewMode && editMode) {
            viewMode.classList.toggle('hidden');
            editMode.classList.toggle('hidden');
        }
    }

    function setOrderRating(rating, itemId) {
        const ratingInput = document.getElementById(`rating-input-${itemId}`);
        if (!ratingInput) return;
        
        ratingInput.value = rating;
        
        const stars = document.querySelectorAll(`.star-btn-${itemId}`);
        stars.forEach(btn => {
            const btnRating = parseInt(btn.dataset.rating);
            if (btnRating <= rating) {
                btn.classList.add('text-amber-400');
                btn.classList.remove('text-gray-300');
            } else {
                btn.classList.add('text-gray-300');
                btn.classList.remove('text-amber-400');
            }
        });
    }
</script>
