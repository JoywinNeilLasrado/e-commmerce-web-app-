@extends('layouts.app')

@section('title', 'Contact Us — PhoneShop')

@section('content')
<div style="margin-top:80px;">

    {{-- Hero --}}
    <div style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%); padding: 4rem 1rem 5rem;">
        <div class="max-w-4xl mx-auto text-center">
            <div style="width:4rem;height:4rem;background:rgba(255,255,255,0.1);border-radius:1rem;display:flex;align-items:center;justify-content:center;font-size:2rem;margin:0 auto 1.25rem;">💬</div>
            <h1 class="text-4xl font-extrabold text-white mb-3 tracking-tight">Contact Us</h1>
            <p class="text-blue-200 text-lg max-w-xl mx-auto">We're here to help! Reach out and our team will get back to you within 24 hours.</p>
        </div>
    </div>

    {{-- Content --}}
    <div class="bg-gray-50 -mt-6 pt-10 pb-20" style="border-radius:1.5rem 1.5rem 0 0;">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left: Contact Info --}}
                <div class="space-y-5">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h2 class="font-bold text-gray-900 mb-5">📍 Get in Touch</h2>
                        <div class="space-y-5">
                            @foreach([
                                ['📧','Email','support@phoneshop.in','mailto:support@phoneshop.in'],
                                ['📞','Phone','+91 98765 43210','tel:+919876543210'],
                                ['⏰','Business Hours','Mon–Sat: 10am – 7pm IST',null],
                                ['📍','Address','PhoneShop HQ, 4th Floor, Tech Park, Whitefield, Bangalore – 560066',null],
                            ] as [$icon, $label, $value, $href])
                            <div class="flex gap-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0 text-lg">{{ $icon }}</div>
                                <div>
                                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-0.5">{{ $label }}</p>
                                    @if($href)
                                        <a href="{{ $href }}" class="text-sm text-blue-600 font-medium hover:underline">{{ $value }}</a>
                                    @else
                                        <p class="text-sm text-gray-700 leading-relaxed">{{ $value }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h2 class="font-bold text-gray-900 mb-4">⚡ Quick Links</h2>
                        <div class="space-y-2">
                            @foreach([
                                ['Warranty Policy', 'support.warranty'],
                                ['Returns & Refunds', 'support.returns'],
                                ['Shipping Info', 'support.shipping'],
                                ['My Orders', 'orders.index'],
                            ] as [$label, $route])
                            <a href="{{ route($route) }}"
                               class="flex items-center justify-between py-2.5 px-3 rounded-xl text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors group">
                                {{ $label }}
                                <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Right: Contact Form --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-7 py-5 border-b border-gray-50" style="background:linear-gradient(135deg,#f8faff,#f0f4ff);">
                            <h2 class="font-bold text-gray-900">Send us a Message</h2>
                            <p class="text-sm text-gray-500 mt-0.5">We'll reply within 24 hours on business days.</p>
                        </div>
                        <div class="p-7">

                            {{-- Success --}}
                            @if(session('contact_success'))
                            <div class="mb-6 flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-4 text-sm">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                <p>{{ session('contact_success') }}</p>
                            </div>
                            @endif

                            <form action="{{ route('support.contact') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Your Name</label>
                                        <input type="text" name="name" value="{{ old('name', auth()->user()?->name) }}"
                                               class="w-full px-4 py-2.5 border-1.5 border-gray-200 rounded-xl text-sm bg-gray-50 focus:outline-none focus:border-blue-500 focus:bg-white transition-all"
                                               style="border:1.5px solid {{ $errors->has('name') ? '#dc2626' : '#e5e7eb' }};"
                                               placeholder="John Doe">
                                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Email Address</label>
                                        <input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}"
                                               class="w-full px-4 py-2.5 rounded-xl text-sm bg-gray-50 focus:outline-none focus:bg-white transition-all"
                                               style="border:1.5px solid {{ $errors->has('email') ? '#dc2626' : '#e5e7eb' }};"
                                               placeholder="you@email.com">
                                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Subject</label>
                                    <select name="subject"
                                            style="width:100%;padding:.625rem 1rem;border:1.5px solid {{ $errors->has('subject') ? '#dc2626' : '#e5e7eb' }};border-radius:.75rem;font-size:.875rem;background:#fafafa;color:#111827;outline:none;">
                                        <option value="">Select a topic…</option>
                                        @foreach(['Warranty Claim','Return Request','Shipping Query','Order Issue','Product Question','Other'] as $opt)
                                            <option value="{{ $opt }}" {{ old('subject') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    @error('subject')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Message</label>
                                    <textarea name="message" rows="5"
                                              style="width:100%;padding:.625rem 1rem;border:1.5px solid {{ $errors->has('message') ? '#dc2626' : '#e5e7eb' }};border-radius:.75rem;font-size:.875rem;background:#fafafa;color:#111827;outline:none;resize:vertical;"
                                              placeholder="Describe your issue or question in detail…">{{ old('message') }}</textarea>
                                    @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>

                                <button type="submit"
                                        class="w-full py-3 px-6 rounded-xl font-semibold text-white text-sm transition-all"
                                        style="background:linear-gradient(135deg,#667eea,#764ba2);box-shadow:0 4px 14px rgba(102,126,234,.4);">
                                    Send Message →
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
