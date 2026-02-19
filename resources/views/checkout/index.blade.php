@extends('layouts.app')

@section('title', 'Checkout — PhoneShop')

@section('content')
<div class="bg-gray-50 min-h-screen pt-24 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="flex items-center gap-4 mb-10 fade-in-section">
            <a href="{{ route('cart.index') }}" class="p-2 text-gray-400 hover:text-gray-700 hover:bg-white rounded-xl border border-gray-200 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
            </a>
            <div>
                <h1 class="text-3xl font-black text-gray-900">Checkout</h1>
                <p class="text-sm text-gray-500 mt-0.5">Secure & encrypted payment</p>
            </div>
        </div>

        <!-- Steps Indicator -->
        <div class="flex items-center gap-2 mb-10 fade-in-section">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</div>
                <span class="text-sm font-bold text-blue-600 hidden sm:block">Address</span>
            </div>
            <div class="flex-1 h-0.5 bg-blue-200 max-w-16"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</div>
                <span class="text-sm font-bold text-blue-600 hidden sm:block">Payment</span>
            </div>
            <div class="flex-1 h-0.5 bg-gray-200 max-w-16"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center text-sm font-bold">3</div>
                <span class="text-sm font-medium text-gray-400 hidden sm:block">Confirm</span>
            </div>
        </div>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left: Address + Payment -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Delivery Address -->
                    <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm fade-in-section">
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <h2 class="text-lg font-black text-gray-900">Delivery Address</h2>
                            </div>
                            <a href="{{ route('profile.edit') }}"
                               class="text-xs font-bold text-blue-600 hover:text-blue-700 border border-blue-200 hover:border-blue-300 px-3 py-1.5 rounded-lg transition-all">
                                + Add New
                            </a>
                        </div>

                        @if($addresses->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($addresses as $address)
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="address_id" value="{{ $address->id }}"
                                               class="sr-only peer" {{ $loop->first ? 'checked' : '' }}>
                                        <div class="border-2 border-gray-100 peer-checked:border-blue-500 peer-checked:bg-blue-50 rounded-2xl p-5 transition-all duration-200 hover:border-blue-200">
                                            <div class="flex items-start justify-between mb-2">
                                                <p class="font-bold text-gray-900 text-sm">{{ $address->full_name }}</p>
                                                <div class="w-4 h-4 border-2 border-gray-300 peer-checked:border-blue-500 rounded-full flex items-center justify-center flex-shrink-0 ml-2">
                                                    <div class="w-2 h-2 bg-blue-500 rounded-full opacity-0 peer-checked:opacity-100"></div>
                                                </div>
                                            </div>
                                            <p class="text-xs text-gray-500 leading-relaxed">
                                                {{ $address->address_line_1 }},
                                                @if($address->address_line_2) {{ $address->address_line_2 }}, @endif
                                                {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}
                                            </p>
                                            <p class="text-xs font-medium text-gray-700 mt-2">📞 {{ $address->phone }}</p>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                <p class="text-sm text-gray-500 mb-4">No saved addresses found.</p>
                                <a href="{{ route('profile.edit') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700 transition-colors">Add a delivery address →</a>
                            </div>
                        @endif
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm fade-in-section delay-100">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            </div>
                            <h2 class="text-lg font-black text-gray-900">Payment Method</h2>
                        </div>

                        <div class="space-y-3">
                            @foreach([['card', 'Credit / Debit Card', '💳', 'Simulated'], ['upi', 'UPI Payment', '📱', 'Simulated'], ['cod', 'Cash on Delivery', '💵', 'No extra charge']] as [$value, $label, $icon, $note])
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="payment_method" value="{{ $value }}"
                                           class="sr-only peer" {{ $value === 'card' ? 'checked' : '' }}>
                                    <div class="flex items-center gap-4 border-2 border-gray-100 peer-checked:border-blue-500 peer-checked:bg-blue-50 rounded-2xl p-5 transition-all duration-200 hover:border-blue-200">
                                        <span class="text-2xl">{{ $icon }}</span>
                                        <div class="flex-1">
                                            <p class="font-bold text-gray-900 text-sm">{{ $label }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $note }}</p>
                                        </div>
                                        <div class="w-5 h-5 border-2 border-gray-300 peer-checked:border-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                                            <div class="w-2.5 h-2.5 bg-blue-500 rounded-full opacity-0 peer-checked:opacity-100 transition-opacity"></div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right: Order Summary -->
                <div class="lg:col-span-1 fade-in-section delay-200">
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm sticky top-28">
                        <h2 class="text-lg font-black text-gray-900 mb-6">Your Order</h2>

                        <div class="space-y-4 max-h-64 overflow-y-auto mb-6 pr-1">
                            @foreach($cart->items as $item)
                                <div class="flex gap-3">
                                    <div class="w-12 h-12 flex-shrink-0 bg-gray-50 rounded-xl overflow-hidden border border-gray-100 flex items-center justify-center p-1">
                                        <img src="{{ $item->productVariant->product->primary_image_url }}" class="w-full h-full object-contain">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-bold text-gray-900 truncate">{{ $item->productVariant->product->title }}</p>
                                        <p class="text-[10px] text-gray-400">{{ $item->productVariant->storage }} · Qty {{ $item->quantity }}</p>
                                    </div>
                                    <p class="text-sm font-black text-gray-900 flex-shrink-0">₹{{ number_format($item->price * $item->quantity, 0) }}</p>
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
                                <span class="font-black text-gray-900">Total</span>
                                <span class="text-2xl font-black text-blue-600">₹{{ number_format($cart->items->sum(fn($i) => $i->price * $i->quantity), 0) }}</span>
                            </div>

                        </div>

                        <button type="submit"
                                class="btn-ripple mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl transition-all duration-200 shadow-lg shadow-blue-600/30 hover:shadow-blue-600/50 hover:scale-[1.02] active:scale-[0.98]">
                            Place Order
                        </button>

                        <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            256-bit SSL encrypted
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Peer-checked simulation for radio buttons
document.querySelectorAll('input[type="radio"]').forEach(input => {
    input.addEventListener('change', function() {
        const name = this.name;
        document.querySelectorAll(`input[name="${name}"]`).forEach(i => {
            const container = i.closest('label').querySelector('div');
            if (container) {
                container.classList.remove('border-blue-500', 'bg-blue-50');
                container.classList.add('border-gray-100');
                const dot = container.querySelector('.bg-blue-500');
                if (dot) dot.classList.add('opacity-0');
            }
        });
        const selectedContainer = this.closest('label').querySelector('div');
        if (selectedContainer) {
            selectedContainer.classList.remove('border-gray-100');
            selectedContainer.classList.add('border-blue-500', 'bg-blue-50');
            const dot = selectedContainer.querySelector('.bg-blue-500');
            if (dot) dot.classList.remove('opacity-0');
        }
    });
});
</script>
@endsection
