@extends('layouts.app')

@section('title', 'Shipping Info — PhoneShop')

@section('content')
<div style="margin-top:80px;">

    {{-- Hero --}}
    <div style="background: linear-gradient(135deg, #1e3a5f 0%, #1a56db 60%, #1c3faa 100%); padding: 4rem 1rem 5rem;">
        <div class="max-w-4xl mx-auto text-center">
            <div style="width:4rem;height:4rem;background:rgba(255,255,255,0.1);border-radius:1rem;display:flex;align-items:center;justify-content:center;font-size:2rem;margin:0 auto 1.25rem;">🚚</div>
            <h1 class="text-4xl font-extrabold text-white mb-3 tracking-tight">Shipping Info</h1>
            <p class="text-blue-200 text-lg max-w-xl mx-auto">Fast, secure, and fully tracked delivery across India. We partner with India's most reliable courier networks.</p>
        </div>
    </div>

    {{-- Content --}}
    <div class="bg-gray-50 -mt-6 pt-10 pb-20" style="border-radius:1.5rem 1.5rem 0 0;">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Delivery Options --}}
            <h2 class="text-xl font-bold text-gray-900 mb-5">📦 Delivery Options</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">
                @foreach([
                    ['🚀','Express Delivery','1–2 Business Days','₹99','Available in metro cities: Mumbai, Delhi, Bangalore, Chennai, Hyderabad, Pune'],
                    ['📦','Standard Delivery','3–5 Business Days','₹49','Available across India. Most popular choice.'],
                    ['🆓','Free Shipping','3–5 Business Days','Free','Orders above ₹15,000 qualify for free standard delivery.'],
                ] as [$icon, $name, $time, $cost, $note])
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <div class="text-2xl mb-3">{{ $icon }}</div>
                    <h3 class="font-bold text-gray-900 mb-1">{{ $name }}</h3>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm text-gray-500">{{ $time }}</span>
                        <span class="font-bold text-blue-600">{{ $cost }}</span>
                    </div>
                    <p class="text-xs text-gray-400 leading-relaxed">{{ $note }}</p>
                </div>
                @endforeach
            </div>

            {{-- Process Timeline --}}
            <div class="bg-white rounded-2xl p-7 shadow-sm border border-gray-100 mb-5">
                <h2 class="text-lg font-bold text-gray-900 mb-6">🕐 Order Timeline</h2>
                <div class="relative">
                    <div class="absolute left-5 top-0 bottom-0 w-0.5 bg-blue-100"></div>
                    <div class="space-y-6">
                        @foreach([
                            ['Order Placed','Your order is confirmed and payment verified.','Day 0','blue'],
                            ['Processing','Our team inspects and packages your device securely.','Day 1','indigo'],
                            ['Dispatched','Device handed to courier. You receive tracking details via email/SMS.','Day 1–2','purple'],
                            ['In Transit','Package on its way! Track it using the link in your email.','Day 2–4','blue'],
                            ['Delivered','Your device arrives! Inspect it before signing.','Day 2–5','green'],
                        ] as [$title, $desc, $day, $color])
                        <div class="flex gap-4 items-start relative">
                            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-50 border-2 border-blue-200 flex items-center justify-center z-10">
                                <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                            </div>
                            <div class="flex-1 pb-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-semibold text-gray-900 text-sm">{{ $title }}</h3>
                                    <span class="text-xs text-gray-400 bg-gray-50 px-2.5 py-1 rounded-full">{{ $day }}</span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">{{ $desc }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Packaging + Tracking --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-base font-bold text-gray-900 mb-4">📱 Secure Packaging</h2>
                    <ul class="space-y-2.5">
                        @foreach([
                            'Anti-static bubble wrap protection',
                            'Double-boxed for fragile devices',
                            'Tamper-evident seal on all packages',
                            'Accessories packed separately to prevent scratches',
                            'Temperature-resistant packaging for extreme weather',
                        ] as $item)
                        <li class="text-sm text-gray-600 flex items-start gap-2"><span class="text-blue-500 flex-shrink-0">▸</span>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-base font-bold text-gray-900 mb-4">📍 Order Tracking</h2>
                    <p class="text-sm text-gray-500 mb-4 leading-relaxed">You'll receive real-time tracking updates via email and SMS once your order is dispatched.</p>
                    <ul class="space-y-2.5">
                        @foreach([
                            'Tracking link sent to your email at dispatch',
                            'SMS updates at key milestones',
                            'View tracking from your Orders page',
                            'Estimated delivery window shown in real time',
                        ] as $item)
                        <li class="text-sm text-gray-600 flex items-start gap-2"><span class="text-blue-500 flex-shrink-0">▸</span>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- CTA --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                <p class="text-gray-700 font-medium mb-1">Have a shipping question?</p>
                <p class="text-gray-400 text-sm mb-4">Our team replies within 4 hours on business days.</p>
                <a href="{{ route('support.contact') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-semibold text-white text-sm"
                   style="background:linear-gradient(135deg,#1a56db,#1c3faa);box-shadow:0 4px 14px rgba(26,86,219,.4);">
                    Contact Support →
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
