@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="bg-gray-50 min-h-screen pt-24 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">My Profile</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Profile Information -->
            <div class="md:col-span-1 space-y-6">
                <!-- Update Profile -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h2 class="text-xl font-semibold mb-4">Profile Information</h2>
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Save</button>
                        </div>
                    </form>
                </div>

                <!-- Update Password -->
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h2 class="text-xl font-semibold mb-4">Update Password</h2>
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                <input type="password" name="current_password" id="current_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                                <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                            <button type="submit" class="w-full bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Address Book -->
            <div class="md:col-span-2">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold">Address Book</h2>
                        <button onclick="document.getElementById('add-address-form').classList.toggle('hidden')" class="text-sm text-indigo-600 hover:text-indigo-900">+ Add New Address</button>
                    </div>

                    <!-- Add Address Form -->
                    <div id="add-address-form" class="hidden mb-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <h3 class="font-medium text-gray-900 mb-4">Add New Address</h3>
                        <form action="{{ route('profile.address.store') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Label (e.g. Home, Work)</label>
                                    <input type="text" name="label" value="{{ old('label') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('label') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Full Name</label>
                                    <input type="text" name="full_name" value="{{ old('full_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('full_name') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-700">Address Line 1</label>
                                    <input type="text" name="address_line_1" value="{{ old('address_line_1') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('address_line_1') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-700">Address Line 2 (Optional)</label>
                                    <input type="text" name="address_line_2" value="{{ old('address_line_2') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('address_line_2') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">City</label>
                                    <input type="text" name="city" value="{{ old('city') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('city') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">State</label>
                                    <input type="text" name="state" value="{{ old('state') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('state') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Postal Code</label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('postal_code') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Country</label>
                                    <input type="text" name="country" value="{{ old('country', 'India') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('country') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700">Phone</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('phone') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_default" id="is_default" value="1" {{ old('is_default') ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_default" class="ml-2 block text-sm text-gray-900">Set as default</label>
                                </div>
                            </div>
                            <div class="mt-4 flex justify-end">
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">Save Address</button>
                            </div>
                        </form>
                    </div>

                    <!-- Address List -->
                    <div class="space-y-4">
                        @forelse($user->addresses as $address)
                            <div class="flex justify-between items-start border border-gray-200 rounded-lg p-4 {{ $address->is_default ? 'bg-indigo-50 border-indigo-200' : '' }}">
                                <div>
                                    <div class="flex items-center">
                                        <span class="font-medium text-gray-900">{{ $address->label }}</span>
                                        @if($address->is_default)
                                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">Default</span>
                                        @endif
                                    </div>
                                    <div class="mt-1 text-sm text-gray-600">
                                        <p class="font-medium">{{ $address->full_name }}</p>
                                        <p>{{ $address->address_line_1 }}</p>
                                        @if($address->address_line_2) <p>{{ $address->address_line_2 }}</p> @endif
                                        <p>{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                                        <p>{{ $address->country }}</p>
                                        <p class="mt-1">📞 {{ $address->phone }}</p>
                                    </div>
                                </div>
                                <div class="ml-4 flex-shrink-0">
                                    <form action="{{ route('profile.address.destroy', $address) }}" method="POST" onsubmit="return confirm('Delete this address?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">No addresses saved yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
