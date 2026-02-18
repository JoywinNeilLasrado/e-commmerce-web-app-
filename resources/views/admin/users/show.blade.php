@extends('layouts.app')

@section('title', 'User Details - ' . $user->name)

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-600 hover:text-gray-900">← Back to Users</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- User Profile & Role -->
            <div class="md:col-span-1 space-y-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex flex-col items-center">
                        <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-3xl mb-4">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <h2 class="text-xl font-semibold text-gray-900">{{ $user->name }}</h2>
                        <p class="text-sm text-gray-500 mb-4">{{ $user->email }}</p>
                        
                        <div class="w-full pt-4 border-t border-gray-100">
                            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <div class="flex space-x-2">
                                    <select name="role" id="role" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-gray-900 focus:border-gray-900 sm:text-sm rounded-md">
                                        <option value="customer" {{ $user->hasRole('customer') ? 'selected' : '' }}>Customer</option>
                                        <option value="admin" {{ $user->hasRole('admin') ? 'selected' : '' }}>Admin</option>
                                    </select>
                                    <button type="submit" class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm hover:bg-gray-800">Save</button>
                                </div>
                            </form>
                        </div>

                        <div class="w-full mt-6 pt-4 border-t border-gray-100">
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full text-red-600 hover:text-red-900 text-sm font-medium">Delete Account</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Addresses -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Addresses</h3>
                    <div class="space-y-4">
                        @forelse($user->addresses as $address)
                            <div class="text-sm text-gray-600 border-b border-gray-100 pb-2 last:border-0 last:pb-0">
                                <span class="font-medium text-gray-900">{{ $address->label }}</span>
                                @if($address->is_default) <span class="text-xs bg-gray-100 text-gray-600 px-1 rounded">Default</span> @endif
                                <br>
                                {{ $address->full_address }}<br>
                                📞 {{ $address->phone }}
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No addresses saved.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Order History -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order History</h3>
                    <div class="space-y-4">
                        @forelse($user->orders as $order)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition cursor-pointer" onclick="window.location='{{ route('admin.orders.show', $order) }}'">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <span class="font-medium text-gray-900">{{ $order->order_number }}</span>
                                        <span class="text-xs text-gray-500 ml-2">{{ $order->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full
                                        @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status == 'shipped') bg-purple-100 text-purple-800
                                        @elseif($order->status == 'delivered') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-600">
                                    {{ $order->items->count() }} item(s) • Total: ₹{{ number_format($order->total, 0) }}
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-8">No orders yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
