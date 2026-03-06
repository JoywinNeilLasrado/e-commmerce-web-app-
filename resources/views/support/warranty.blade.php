@extends('layouts.app')

@section('title', 'Warranty Policy — PhoneShop')

@section('content')
<div style="margin-top:80px;">

    {{-- Hero --}}
    <div style="background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%); padding: 4rem 1rem 5rem;">
        <div class="max-w-4xl mx-auto text-center">
            <div style="width:4rem;height:4rem;background:rgba(255,255,255,0.1);border-radius:1rem;display:flex;align-items:center;justify-content:center;font-size:2rem;margin:0 auto 1.25rem;">🛡️</div>
            <h1 class="text-4xl font-extrabold text-white mb-3 tracking-tight">Warranty Policy</h1>
            <p class="text-indigo-200 text-lg max-w-xl mx-auto">Every device we sell is backed by our comprehensive 12-month warranty. Your peace of mind is our priority.</p>
        </div>
    </div>

    {{-- Content --}}
    <div class="bg-gray-50 -mt-6 pt-10 pb-20" style="border-radius:1.5rem 1.5rem 0 0;">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Coverage Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-10">
                @foreach([
                    ['icon'=>'✅','title'=>'12-Month Coverage','desc'=>'All certified refurbished phones come with a full 12-month warranty from the date of purchase.'],
                    ['icon'=>'🔧','title'=>'Free Repairs','desc'=>'Any manufacturing defects or hardware failures covered under warranty are repaired or replaced at no cost.'],
                    ['icon'=>'🚚','title'=>'Free Return Shipping','desc'=>'We cover all shipping costs for warranty claims. Just contact us and we\'ll arrange the pickup.'],
                ] as $card)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                    <div style="font-size:2rem;margin-bottom:.75rem;">{{ $card['icon'] }}</div>
                    <h3 class="font-bold text-gray-900 mb-2">{{ $card['title'] }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $card['desc'] }}</p>
                </div>
                @endforeach
            </div>

            {{-- Detailed Sections --}}
            @foreach([
                ['What\'s Covered', '🟢', [
                    'Hardware defects present at time of purchase',
                    'Battery defects (below 80% health within warranty period)',
                    'Screen issues not caused by physical damage',
                    'Camera, speaker, microphone malfunctions',
                    'Charging port and button failures',
                    'Internal component failures (motherboard, RAM, storage)',
                ]],
                ['What\'s Not Covered', '🔴', [
                    'Physical or accidental damage (cracked screens, dents)',
                    'Water or liquid damage',
                    'Damage from unauthorized repairs or modifications',
                    'Normal wear and tear (minor scratches, battery degradation over time)',
                    'Software issues or operating system problems',
                    'Lost or stolen devices',
                ]],
                ['How to Make a Claim', '📋', [
                    'Contact our support team via the Contact Us page or email',
                    'Provide your order number, device details, and describe the issue',
                    'Our team will assess and approve the claim within 1–2 business days',
                    'Ship the device to us (we\'ll send a prepaid label)',
                    'Receive your repaired or replacement device within 7–10 business days',
                ]],
            ] as [$title, $icon, $items])
            <div class="bg-white rounded-2xl p-7 shadow-sm border border-gray-100 mb-5">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span>{{ $icon }}</span> {{ $title }}
                </h2>
                <ul class="space-y-2.5">
                    @foreach($items as $item)
                    <li class="flex items-start gap-2.5 text-sm text-gray-600">
                        <span class="mt-0.5 text-indigo-400 flex-shrink-0">▸</span>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach

            {{-- CTA --}}
            <div class="text-center mt-10">
                <p class="text-gray-500 text-sm mb-4">Need to make a warranty claim?</p>
                <a href="{{ route('support.contact') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-semibold text-white text-sm"
                   style="background:linear-gradient(135deg,#667eea,#764ba2);box-shadow:0 4px 14px rgba(102,126,234,.4);">
                    Contact Support →
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
