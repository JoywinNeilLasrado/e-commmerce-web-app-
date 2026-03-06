@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

<style>
    .profile-hero {
        background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
    }
    .avatar-ring {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .card-glass {
        background: rgba(255,255,255,0.97);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.8);
    }
    .input-field {
        display: block;
        width: 100%;
        padding: 0.625rem 0.875rem;
        border: 1.5px solid #e5e7eb;
        border-radius: 0.625rem;
        font-size: 0.875rem;
        color: #111827;
        background: #fafafa;
        transition: all 0.2s ease;
        outline: none;
        margin-top: 0.375rem;
    }
    .input-field:focus {
        border-color: #6366f1;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }
    .input-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6b7280;
    }
    .btn-primary {
        width: 100%;
        padding: 0.7rem 1.25rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        font-weight: 600;
        font-size: 0.875rem;
        border-radius: 0.625rem;
        border: none;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(102,126,234,0.4);
        letter-spacing: 0.02em;
    }
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(102,126,234,0.5);
    }
    .btn-dark {
        width: 100%;
        padding: 0.7rem 1.25rem;
        background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
        color: #fff;
        font-weight: 600;
        font-size: 0.875rem;
        border-radius: 0.625rem;
        border: none;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(17,24,39,0.3);
        letter-spacing: 0.02em;
    }
    .btn-dark:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(17,24,39,0.4);
    }
    .btn-danger {
        width: 100%;
        padding: 0.7rem 1.25rem;
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
        color: #fff;
        font-weight: 600;
        font-size: 0.875rem;
        border-radius: 0.625rem;
        border: none;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(220,38,38,0.35);
        letter-spacing: 0.02em;
    }
    .btn-danger:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(220,38,38,0.5);
    }
    /* Modal */
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.55);
        backdrop-filter: blur(4px);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }
    .modal-overlay.active {
        display: flex;
    }
    .modal-card {
        background: #fff;
        border-radius: 1.25rem;
        max-width: 420px;
        width: 100%;
        overflow: hidden;
        box-shadow: 0 25px 60px rgba(0,0,0,0.25);
        animation: modalIn 0.25s ease;
    }
    @keyframes modalIn {
        from { opacity: 0; transform: scale(0.94) translateY(12px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }
    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #111827;
        letter-spacing: -0.01em;
    }
    .address-card {
        border: 1.5px solid #e5e7eb;
        border-radius: 1rem;
        padding: 1.25rem;
        transition: all 0.2s ease;
        position: relative;
        overflow: hidden;
    }
    .address-card:hover {
        border-color: #c7d2fe;
        box-shadow: 0 4px 24px rgba(99,102,241,0.08);
        transform: translateY(-1px);
    }
    .address-card.default {
        border-color: #818cf8;
        background: linear-gradient(135deg, #eef2ff 0%, #f5f3ff 100%);
    }
    .address-card.default::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    }
    .add-address-panel {
        background: linear-gradient(135deg, #f8faff 0%, #f3f4ff 100%);
        border: 1.5px dashed #c7d2fe;
        border-radius: 1rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .stat-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.875rem;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        border-radius: 999px;
        font-size: 0.8125rem;
        font-weight: 500;
        color: #fff;
    }
    .card-section {
        background: #fff;
        border-radius: 1.25rem;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 20px rgba(0,0,0,0.04), 0 4px 6px rgba(0,0,0,0.02);
        overflow: hidden;
        margin-bottom: 1.25rem;
    }
    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        gap: 0.625rem;
    }
    .card-icon {
        width: 2rem; height: 2rem;
        border-radius: 0.5rem;
        display: flex; align-items: center; justify-content: center;
        font-size: 1rem;
    }
    .card-body {
        padding: 1.5rem;
    }
</style>

{{-- Hero Banner --}}
<div class="profile-hero relative overflow-hidden" style="margin-top: 80px; padding-top: 3.5rem; padding-bottom: 5rem;">

    {{-- Decorative blobs --}}
    <div class="absolute top-0 left-1/4 w-96 h-96 rounded-full opacity-10"
         style="background: radial-gradient(circle, #818cf8, transparent); filter: blur(60px);"></div>
    <div class="absolute bottom-0 right-1/4 w-80 h-80 rounded-full opacity-10"
         style="background: radial-gradient(circle, #a78bfa, transparent); filter: blur(50px);"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex flex-col sm:flex-row items-center sm:items-end gap-6">
            {{-- Avatar --}}
            <div class="relative">
                <div class="avatar-ring p-1 rounded-full shadow-2xl" style="box-shadow: 0 0 0 4px rgba(255,255,255,0.15);">
                    <div class="w-24 h-24 rounded-full bg-gray-800 flex items-center justify-center text-4xl font-black text-white select-none"
                         style="background: linear-gradient(135deg, #312e81, #4338ca);">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                </div>
            </div>

            {{-- Name & Meta --}}
            <div class="text-center sm:text-left pb-1">
                <h1 class="text-3xl font-extrabold text-white tracking-tight" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                    {{ $user->name }}
                </h1>
                <p class="text-white text-sm mt-0.5 font-medium" style="text-shadow: 0 1px 3px rgba(0,0,0,0.3);">{{ $user->email }}</p>
                <div class="flex flex-wrap gap-2 justify-center sm:justify-start mt-3">
                    <span class="stat-pill">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                        {{ $user->addresses->count() }} {{ Str::plural('Address', $user->addresses->count()) }}
                    </span>
                    <span class="stat-pill">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Member since {{ $user->created_at->format('M Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Main Content --}}
<div class="bg-gray-50 min-h-screen -mt-6 pt-8 pb-16" style="border-radius: 1.5rem 1.5rem 0 0;">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- LEFT: Profile Info + Password --}}
            <div class="lg:col-span-1 space-y-5">

                {{-- Profile Information Card --}}
                <div class="card-section">
                    <div class="card-header">
                        <div class="card-icon" style="background: linear-gradient(135deg,#eef2ff,#e0e7ff);">👤</div>
                        <span class="section-title">Profile Information</span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="input-label">Full Name</label>
                                    <input type="text" name="name" id="name"
                                           value="{{ old('name', $user->name) }}"
                                           class="input-field" placeholder="Your full name">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="input-label">Email Address</label>
                                    <input type="email" name="email" id="email"
                                           value="{{ old('email', $user->email) }}"
                                           class="input-field" placeholder="your@email.com">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1V10a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <button type="submit" class="btn-primary">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Update Password Card --}}
                <div class="card-section">
                    <div class="card-header">
                        <div class="card-icon" style="background: linear-gradient(135deg,#fef3c7,#fde68a);">🔐</div>
                        <span class="section-title">Change Password</span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.password') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="space-y-4">
                                <div>
                                    <label for="current_password" class="input-label">Current Password</label>
                                    <input type="password" name="current_password" id="current_password"
                                           class="input-field" placeholder="••••••••">
                                    @error('current_password')
                                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="password" class="input-label">New Password</label>
                                    <input type="password" name="password" id="password"
                                           class="input-field" placeholder="••••••••">
                                    @error('password')
                                        <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="password_confirmation" class="input-label">Confirm Password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                           class="input-field" placeholder="••••••••">
                                </div>
                                <button type="submit" class="btn-dark">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Danger Zone Card --}}
                <div class="card-section" style="border-color: #fecaca;">
                    <div class="card-header" style="background: linear-gradient(135deg, #fff1f2, #fff5f5); border-bottom-color: #fecaca;">
                        <div class="card-icon" style="background: linear-gradient(135deg,#fee2e2,#fecaca);">🗑️</div>
                        <span class="section-title" style="color:#dc2626;">Danger Zone</span>
                    </div>
                    <div class="card-body">
                        <p class="text-sm text-gray-600 mb-1">Permanently delete your account and all associated data.</p>
                        <p class="text-xs text-red-500 font-medium mb-4">⚠️ This action cannot be undone.</p>
                        <button type="button" onclick="openDeleteModal()"
                                class="btn-danger">
                            Delete My Account
                        </button>
                    </div>
                </div>

            </div>

            {{-- RIGHT: Address Book --}}
            <div class="lg:col-span-2">
                <div class="card-section">
                    <div class="card-header justify-between">
                        <div class="flex items-center gap-2">
                            <div class="card-icon" style="background: linear-gradient(135deg,#dcfce7,#bbf7d0);">📍</div>
                            <span class="section-title">Address Book</span>
                            @if($user->addresses->count())
                                <span class="ml-1 px-2 py-0.5 rounded-full text-xs font-bold text-indigo-700 bg-indigo-50">
                                    {{ $user->addresses->count() }}
                                </span>
                            @endif
                        </div>
                        <button onclick="toggleAddressForm()"
                                id="add-address-btn"
                                class="inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition-colors px-3 py-1.5 rounded-lg hover:bg-indigo-50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Add Address
                        </button>
                    </div>

                    <div class="card-body space-y-4">

                        {{-- Add Address Form (hidden by default) --}}
                        <div id="add-address-form" class="add-address-panel hidden">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="text-sm font-bold text-indigo-700">New Address</span>
                            </div>
                            <form action="{{ route('profile.address.store') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="input-label">Label (e.g. Home, Work)</label>
                                        <input type="text" name="label" value="{{ old('label') }}"
                                               class="input-field" placeholder="Home">
                                        @error('label') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="input-label">Full Name</label>
                                        <input type="text" name="full_name" value="{{ old('full_name') }}"
                                               class="input-field" placeholder="John Doe">
                                        @error('full_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="input-label">Address Line 1</label>
                                        <input type="text" name="address_line_1" value="{{ old('address_line_1') }}"
                                               class="input-field" placeholder="Street, Building, Area">
                                        @error('address_line_1') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label class="input-label">Address Line 2 <span class="normal-case font-normal text-gray-400">(Optional)</span></label>
                                        <input type="text" name="address_line_2" value="{{ old('address_line_2') }}"
                                               class="input-field" placeholder="Apartment, Floor, Landmark">
                                    </div>
                                    <div>
                                        <label class="input-label">City</label>
                                        <input type="text" name="city" value="{{ old('city') }}"
                                               class="input-field" placeholder="Mumbai">
                                        @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="input-label">State</label>
                                        <input type="text" name="state" value="{{ old('state') }}"
                                               class="input-field" placeholder="Maharashtra">
                                        @error('state') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="input-label">Postal Code</label>
                                        <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                                               class="input-field" placeholder="400001">
                                        @error('postal_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="input-label">Country</label>
                                        <input type="text" name="country" value="{{ old('country', 'India') }}"
                                               class="input-field" placeholder="India">
                                        @error('country') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div>
                                        <label class="input-label">Phone</label>
                                        <input type="text" name="phone" value="{{ old('phone') }}"
                                               class="input-field" placeholder="+91 98765 43210">
                                        @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                    </div>
                                    <div class="flex items-center pt-5">
                                        <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                            <input type="checkbox" name="is_default" id="is_default" value="1"
                                                   {{ old('is_default') ? 'checked' : '' }}
                                                   class="w-4 h-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500">
                                            <span class="text-sm font-medium text-gray-700">Set as default address</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" onclick="toggleAddressForm()"
                                            class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 bg-white border border-gray-200 rounded-lg transition hover:bg-gray-50">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="px-5 py-2 text-sm font-semibold text-white rounded-lg transition"
                                            style="background: linear-gradient(135deg,#667eea,#764ba2); box-shadow: 0 3px 10px rgba(102,126,234,0.4);">
                                        Save Address
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Address List --}}
                        @forelse($user->addresses as $address)
                            <div class="address-card {{ $address->is_default ? 'default' : '' }}">
                                <div class="flex justify-between items-start gap-3">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-2 flex-wrap">
                                            @if($address->label)
                                                <span class="inline-flex items-center gap-1 text-sm font-bold text-gray-800">
                                                    {{ $address->label }}
                                                </span>
                                            @endif
                                            @if($address->is_default)
                                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold"
                                                      style="background: linear-gradient(135deg,#667eea,#764ba2); color: #fff;">
                                                    ★ Default
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-sm font-semibold text-gray-900">{{ $address->full_name }}</p>
                                        <div class="text-sm text-gray-500 mt-1 space-y-0.5">
                                            <p>{{ $address->address_line_1 }}</p>
                                            @if($address->address_line_2)
                                                <p>{{ $address->address_line_2 }}</p>
                                            @endif
                                            <p>{{ $address->city }}, {{ $address->state }} – {{ $address->postal_code }}</p>
                                            <p>{{ $address->country }}</p>
                                            <p class="flex items-center gap-1 mt-1.5 text-gray-600">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                                </svg>
                                                {{ $address->phone }}
                                            </p>
                                        </div>
                                    </div>
                                    <form action="{{ route('profile.address.destroy', $address) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this address?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="flex items-center gap-1 text-xs font-medium text-red-400 hover:text-red-600 transition-colors px-2 py-1 rounded-lg hover:bg-red-50">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center text-3xl"
                                     style="background: linear-gradient(135deg,#eef2ff,#e0e7ff);">📭</div>
                                <p class="text-gray-500 font-medium text-sm">No addresses saved yet</p>
                                <p class="text-gray-400 text-xs mt-1">Add your first address to get started</p>
                                <button onclick="toggleAddressForm()"
                                        class="mt-4 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Add your first address
                                </button>
                            </div>
                        @endforelse

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleAddressForm() {
        const form = document.getElementById('add-address-form');
        form.classList.toggle('hidden');
        if (!form.classList.contains('hidden')) {
            form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    function openDeleteModal() {
        document.getElementById('delete-account-modal').classList.add('active');
        document.body.style.overflow = 'hidden';
        setTimeout(() => document.getElementById('delete_password').focus(), 100);
    }

    function closeDeleteModal() {
        document.getElementById('delete-account-modal').classList.remove('active');
        document.body.style.overflow = '';
        document.getElementById('delete_password').value = '';
    }

    // Close modal on overlay click
    document.getElementById('delete-account-modal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });

    // Re-open modal if there's a password validation error from delete attempt
    @if($errors->has('password') && session()->has('delete_attempted'))
        document.addEventListener('DOMContentLoaded', () => openDeleteModal());
    @endif

    // Auto-open address form if there are validation errors in the address section
    @if($errors->hasAny(['label','full_name','phone','address_line_1','city','state','postal_code','country']))
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('add-address-form').classList.remove('hidden');
        });
    @endif
</script>

@endsection

{{-- Delete Account Confirmation Modal --}}
<div id="delete-account-modal" class="modal-overlay" role="dialog" aria-modal="true" aria-labelledby="modal-title">
    <div class="modal-card">

        {{-- Modal Header --}}
        <div style="padding:1.5rem 1.5rem 0; display:flex; align-items:center; gap:0.75rem;">
            <div style="width:2.5rem;height:2.5rem;border-radius:0.75rem;background:linear-gradient(135deg,#fee2e2,#fecaca);display:flex;align-items:center;justify-content:center;font-size:1.25rem;flex-shrink:0;">🗑️</div>
            <div>
                <h2 id="modal-title" style="font-size:1rem;font-weight:700;color:#111827;margin:0;">Delete Account</h2>
                <p style="font-size:0.75rem;color:#6b7280;margin:0;">This cannot be undone</p>
            </div>
            <button onclick="closeDeleteModal()" style="margin-left:auto;background:none;border:none;cursor:pointer;color:#9ca3af;padding:0.25rem;border-radius:0.375rem;line-height:1;" aria-label="Close">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <div style="padding:1.25rem 1.5rem;">
            <div style="background:#fff1f2;border:1px solid #fecaca;border-radius:0.75rem;padding:0.875rem;margin-bottom:1.25rem;">
                <p style="font-size:0.8125rem;color:#dc2626;margin:0;">You are about to permanently delete your account, including all your orders history, addresses, and reviews.</p>
            </div>

            <form id="delete-account-form" action="{{ route('profile.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <div>
                    <label for="delete_password" class="input-label">Confirm your password to continue</label>
                    <input type="password" name="password" id="delete_password"
                           class="input-field" placeholder="Enter your current password"
                           autocomplete="current-password">
                    <div id="delete-password-error" style="display:none;margin-top:0.375rem;">
                        <p style="font-size:0.75rem;color:#dc2626;display:flex;align-items:center;gap:0.25rem;">
                            <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ session('delete_error') ?? 'Incorrect password. Please try again.' }}
                        </p>
                    </div>
                    @if($errors->has('password') && session()->has('delete_attempted'))
                        <p style="font-size:0.75rem;color:#dc2626;margin-top:0.375rem;">{{ $errors->first('password') }}</p>
                    @endif
                </div>

                <div style="display:flex;gap:0.75rem;margin-top:1.25rem;">
                    <button type="button" onclick="closeDeleteModal()"
                            style="flex:1;padding:0.65rem 1rem;font-size:0.875rem;font-weight:600;color:#374151;background:#fff;border:1.5px solid #e5e7eb;border-radius:0.625rem;cursor:pointer;transition:all 0.2s;">
                        Cancel
                    </button>
                    <button type="submit"
                            style="flex:1;padding:0.65rem 1rem;font-size:0.875rem;font-weight:600;color:#fff;background:linear-gradient(135deg,#dc2626,#b91c1c);border:none;border-radius:0.625rem;cursor:pointer;box-shadow:0 4px 12px rgba(220,38,38,0.35);transition:all 0.2s;">
                        Yes, Delete Account
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
