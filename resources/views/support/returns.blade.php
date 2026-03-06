@extends('layouts.app')

@section('title', 'Returns & Refunds — PhoneShop')

@section('content')
<div style="margin-top:80px;">

    {{-- Hero --}}
    <div style="background: linear-gradient(135deg, #134e4a 0%, #065f46 50%, #064e3b 100%); padding: 4rem 1rem 5rem;">
        <div class="max-w-4xl mx-auto text-center">
            <div style="width:4rem;height:4rem;background:rgba(255,255,255,0.1);border-radius:1rem;display:flex;align-items:center;justify-content:center;font-size:2rem;margin:0 auto 1.25rem;">↩️</div>
            <h1 class="text-4xl font-extrabold text-white mb-3 tracking-tight">Returns & Refunds</h1>
            <p class="text-emerald-200 text-lg max-w-xl mx-auto">Not satisfied? We offer a hassle-free 7-day return window on all purchases. No questions asked.</p>
        </div>
    </div>

    {{-- Content --}}
    <div class="bg-gray-50 -mt-6 pt-10 pb-20" style="border-radius:1.5rem 1.5rem 0 0;">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Highlight Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">
                @foreach([
                    ['7','Days','Return window from date of delivery'],
                    ['3–5','Business Days','For refunds to appear on your bank statement'],
                    ['₹0','Cost','Free returns — we cover the shipping label'],
                ] as [$num, $unit, $desc])
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                    <div class="text-3xl font-black text-emerald-600 mb-1">{{ $num }}</div>
                    <div class="text-sm font-semibold text-gray-800 mb-2">{{ $unit }}</div>
                    <p class="text-xs text-gray-500">{{ $desc }}</p>
                </div>
                @endforeach
            </div>

            {{-- Steps --}}
            <div class="bg-white rounded-2xl p-7 shadow-sm border border-gray-100 mb-5">
                <h2 class="text-lg font-bold text-gray-900 mb-6">📦 How to Return a Product</h2>
                <div class="space-y-5">
                    @foreach([
                        ['01', 'Initiate Return', 'Contact our support team within 7 days of delivery via the Contact page or email. Include your order number.'],
                        ['02', 'Get Approved', 'Our team will review and approve your return request within 24 hours.'],
                        ['03', 'Ship it Back', 'We\'ll send you a prepaid shipping label. Pack the device securely in its original box if possible.'],
                        ['04', 'Receive Refund', 'Once we receive and inspect the device, we\'ll process your refund within 3–5 business days.'],
                    ] as [$step, $title, $desc])
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center font-black text-sm text-white"
                             style="background:linear-gradient(135deg,#10b981,#065f46);">{{ $step }}</div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-sm mb-1">{{ $title }}</h3>
                            <p class="text-sm text-gray-500">{{ $desc }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Eligible / Not Eligible --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-base font-bold text-gray-900 mb-4">✅ Eligible for Return</h2>
                    <ul class="space-y-2.5">
                        @foreach([
                            'Device received in incorrect condition (wrong model/colour)',
                            'Significant defect not disclosed in listing',
                            'Device does not power on or is non-functional',
                            'Missing accessories listed in the product description',
                            'Device significantly different from what was advertised',
                        ] as $item)
                        <li class="text-sm text-gray-600 flex items-start gap-2"><span class="text-green-500 flex-shrink-0 mt-0.5">✓</span>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h2 class="text-base font-bold text-gray-900 mb-4">❌ Not Eligible for Return</h2>
                    <ul class="space-y-2.5">
                        @foreach([
                            'Returns requested after 7 days of delivery',
                            'Physical damage caused after delivery',
                            'Device unlocked or tampered with',
                            'Missing original accessories or packaging',
                            'Change of mind after 7-day window has passed',
                        ] as $item)
                        <li class="text-sm text-gray-600 flex items-start gap-2"><span class="text-red-400 flex-shrink-0 mt-0.5">✗</span>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- Refund Methods --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8">
                <h2 class="text-base font-bold text-gray-900 mb-4">💳 Refund Methods</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach([
                        ['Original Payment Method','Refund credited back to the card or UPI used for purchase. Takes 3–5 business days.'],
                        ['Bank Transfer','Direct NEFT transfer to your account. Requires bank details. Takes 2–3 business days.'],
                        ['Store Credit','Instant credit to your PhoneShop account that can be used for your next purchase.'],
                    ] as [$method, $desc])
                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                        <p class="font-semibold text-sm text-gray-800 mb-1">{{ $method }}</p>
                        <p class="text-xs text-gray-500 leading-relaxed">{{ $desc }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- CTA --}}
            <div class="text-center">
                <p class="text-gray-500 text-sm mb-4">Ready to start a return?</p>
                <a href="{{ route('support.contact') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-semibold text-white text-sm"
                   style="background:linear-gradient(135deg,#10b981,#065f46);box-shadow:0 4px 14px rgba(16,185,129,.4);">
                    Contact Us to Return →
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
