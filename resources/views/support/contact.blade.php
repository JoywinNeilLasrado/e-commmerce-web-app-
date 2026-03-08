@extends('layouts.app')

@section('title', $page->title . ' — PhoneShop')

@section('content')
<div class="bg-[#F0FAFE] min-h-screen">
    <div class="bg-transparent border-b border-gray-100 py-16">
        <div class="max-w-4xl mx-auto px-4 text-center mt-6">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gray-50 text-gray-900 border border-gray-200 mb-6 shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
            </div>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">{{ $page->title }}</h1>
            @if($page->meta_description)
            <p class="text-gray-500 text-lg max-w-xl mx-auto">{{ $page->meta_description }}</p>
            @endif
        </div>
    </div>
    <div class="bg-transparent py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left: DB info content + quick links --}}
                <div class="space-y-5">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <style>
                            .page-content h2 { font-size:1rem; font-weight:700; color:#111827; margin-bottom:.75rem; }
                            .page-content p  { font-size:.875rem; color:#4b5563; margin-bottom:.5rem; line-height:1.6; }
                            .page-content ul { padding-left:1rem; margin-bottom:.5rem; list-style:disc; }
                            .page-content li { font-size:.875rem; color:#4b5563; margin-bottom:.3rem; }
                            .page-content strong { font-weight:600; color:#1f2937; }
                        </style>
                        <div class="page-content">{!! $page->content !!}</div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <h2 class="font-bold text-gray-900 mb-4">Quick Links</h2>
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
                                <svg class="w-4 h-4 text-gray-300 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Right: Contact Form --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-100 bg-white">
                            <h2 class="font-bold text-gray-900 text-lg">Send us a Message</h2>
                            <p class="text-sm text-gray-500 mt-1">We'll reply within 24 hours on business days.</p>
                        </div>
                        <div class="p-8">
                            @if(session('contact_success'))
                            <div class="mb-6 flex items-start gap-3 bg-green-50 border border-green-200 text-green-800 rounded-xl px-5 py-4 text-sm">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                <p>{{ session('contact_success') }}</p>
                            </div>
                            @endif
                            <form action="{{ route('support.contact') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Your Name</label>
                                        <input type="text" name="name" value="{{ old('name', auth()->user()?->name) }}"
                                               style="width:100%;padding:.625rem 1rem;border:1.5px solid {{ $errors->has('name') ? '#dc2626' : '#e5e7eb' }};border-radius:.75rem;font-size:.875rem;background:#fafafa;"
                                               placeholder="John Doe">
                                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Email Address</label>
                                        <input type="email" name="email" value="{{ old('email', auth()->user()?->email) }}"
                                               style="width:100%;padding:.625rem 1rem;border:1.5px solid {{ $errors->has('email') ? '#dc2626' : '#e5e7eb' }};border-radius:.75rem;font-size:.875rem;background:#fafafa;"
                                               placeholder="you@email.com">
                                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>
                                </div>
                                <div class="mb-6">
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Subject</label>
                                    <select name="subject" style="width:100%;padding:.625rem 1rem;border:1.5px solid {{ $errors->has('subject') ? '#dc2626' : '#e5e7eb' }};border-radius:.75rem;font-size:.875rem;background:#fafafa;color:#111827;">
                                        <option value="">Select a topic…</option>
                                        @foreach(['Warranty Claim','Return Request','Shipping Query','Order Issue','Product Question','Other'] as $opt)
                                            <option value="{{ $opt }}" {{ old('subject') == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                                        @endforeach
                                    </select>
                                    @error('subject')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div class="mb-8">
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-2">Message</label>
                                    <textarea name="message" rows="5"
                                              style="width:100%;padding:.625rem 1rem;border:1.5px solid {{ $errors->has('message') ? '#dc2626' : '#e5e7eb' }};border-radius:.75rem;font-size:.875rem;background:#fafafa;resize:vertical;"
                                              placeholder="Describe your issue…">{{ old('message') }}</textarea>
                                    @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                                <button type="submit" class="w-full py-3 px-6 rounded-xl font-semibold text-white text-sm bg-gray-900 hover:bg-black transition-colors shadow-lg shadow-gray-900/20">
                                    Send Message
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
