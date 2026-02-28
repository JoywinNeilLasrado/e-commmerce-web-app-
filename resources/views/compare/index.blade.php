@extends('layouts.app')

@section('title', 'Compare Phones — PhoneShop')

@section('content')
<div class="bg-gray-50 min-h-screen pt-24 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-10">
            <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-2">Side-by-Side</p>
            <h1 class="text-4xl font-black text-gray-900">Compare Phones</h1>
            <p class="text-gray-500 mt-2">Select up to 3 phones to compare specs and prices.</p>
        </div>

        <!-- Product Selectors -->
        <form method="GET" action="{{ route('compare.index') }}" id="compare-form">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10">
                @for($slot = 0; $slot < 3; $slot++)
                    <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm">
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">
                            Phone {{ $slot + 1 }}
                        </label>
                        <select name="ids[]"
                                onchange="document.getElementById('compare-form').submit()"
                                class="w-full text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 transition-all">
                            <option value="">— Select a phone —</option>
                            @foreach($allProducts as $product)
                                <option value="{{ $product->id }}"
                                    {{ isset($ids[$slot]) && $ids[$slot] == $product->id ? 'selected' : '' }}>
                                    {{ $product->title }}
                                    @if($product->phoneModel?->brand)
                                        ({{ $product->phoneModel->brand->name }})
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endfor
            </div>
        </form>

        @if($compareProducts->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-24 bg-white rounded-3xl border border-gray-100 shadow-sm">
                <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-gray-900 mb-2">Pick phones to compare</h2>
                <p class="text-gray-400">Use the dropdowns above to select up to 3 phones.</p>
            </div>
        @else
            <!-- Comparison Table -->
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-x-auto">
                <table class="w-full min-w-[640px]">

                    <!-- Product Header Row -->
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="p-6 bg-gray-50/80 text-left w-44">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Specs</span>
                            </th>
                            @foreach($compareProducts as $product)
                                <th class="p-6 border-l border-gray-100 text-center align-top">
                                    <div class="flex flex-col items-center gap-3">
                                        <!-- Image -->
                                        <div class="w-28 h-28 rounded-2xl bg-gray-50 border border-gray-100 overflow-hidden flex items-center justify-center p-2">
                                            <img src="{{ $product->primary_image_url }}"
                                                 alt="{{ $product->title }}"
                                                 class="w-full h-full object-contain">
                                        </div>
                                        @if($product->phoneModel?->brand)
                                            <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">{{ $product->phoneModel->brand->name }}</span>
                                        @endif
                                        <h3 class="text-sm font-black text-gray-900 leading-tight">{{ $product->title }}</h3>
                                        <div class="text-center">
                                            <p class="text-xl font-black text-gray-900">₹{{ number_format($product->price, 0) }}</p>
                                            @if($product->original_price > $product->price)
                                                <p class="text-xs text-gray-400 line-through">₹{{ number_format($product->original_price, 0) }}</p>
                                                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                                                    {{ $product->discount_percentage }}% OFF
                                                </span>
                                            @endif
                                        </div>
                                        <a href="{{ route('products.show', $product->slug) }}"
                                           class="w-full inline-flex items-center justify-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition-all hover:scale-105 active:scale-95 shadow-md shadow-blue-600/20">
                                            View &amp; Buy
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                        </a>
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $specRows = [
                                ['label' => '💰 Starting Price',  'key' => 'price',       'section' => 'Pricing'],
                                ['label' => '📦 Storage Options', 'key' => 'storage',     'section' => 'Pricing'],
                                ['label' => '🎨 Colors',          'key' => 'colors',      'section' => 'Pricing'],
                                ['label' => '⭐ Condition',        'key' => 'condition',   'section' => 'Pricing'],
                                ['label' => '📦 In Stock',        'key' => 'stock',       'section' => 'Pricing'],
                                ['label' => '🛡️ Warranty',        'key' => 'warranty',    'section' => 'Pricing'],
                                ['label' => '📱 Display',         'key' => 'display',     'section' => 'Specs'],
                                ['label' => '⚡ Processor',       'key' => 'processor',   'section' => 'Specs'],
                                ['label' => '🧠 RAM',             'key' => 'ram',         'section' => 'Specs'],
                                ['label' => '📷 Camera',          'key' => 'camera',      'section' => 'Specs'],
                                ['label' => '🔋 Battery',         'key' => 'battery',     'section' => 'Specs'],
                                ['label' => '💻 OS',              'key' => 'os',          'section' => 'Specs'],
                            ];

                            $lastSection = null;
                        @endphp

                        @foreach($specRows as $rowIndex => $row)
                            @if($row['section'] !== $lastSection)
                                @php $lastSection = $row['section']; @endphp
                                <tr class="bg-gray-900">
                                    <td colspan="{{ $compareProducts->count() + 1 }}" class="px-6 py-2">
                                        <span class="text-xs font-black text-gray-400 uppercase tracking-widest">{{ $row['section'] }}</span>
                                    </td>
                                </tr>
                            @endif

                            <tr class="{{ $rowIndex % 2 === 0 ? 'bg-white' : 'bg-gray-50/40' }} border-b border-gray-100 last:border-0">
                                <td class="px-6 py-4">
                                    <span class="text-xs font-semibold text-gray-500">{{ $row['label'] }}</span>
                                </td>

                                @foreach($compareProducts as $product)
                                    @php
                                        $pm = $product->phoneModel;
                                        $inStock = $product->inStock();

                                        $value = match($row['key']) {
                                            'price'     => '₹' . number_format($product->price, 0),
                                            'storage'   => $product->storage ?? '—',
                                            'colors'    => $product->color ?? '—',
                                            'condition' => $product->condition?->name ?? '—',
                                            'stock'     => $inStock ? 'In Stock' : 'Out of Stock',
                                            'warranty'  => $product->warranty_months . ' months',
                                            'display'   => ($pm?->display_size && $pm?->display_type) ? $pm->display_size . ' ' . $pm->display_type : ($pm?->display_size ?? '—'),
                                            'processor' => $pm?->processor ?? '—',
                                            'ram'       => $pm?->ram ?? '—',
                                            'camera'    => $pm?->camera ?? '—',
                                            'battery'   => $pm?->battery ?? '—',
                                            'os'        => $pm?->os ?? '—',
                                            default     => '—',
                                        };

                                        $isStock = $row['key'] === 'stock';
                                    @endphp
                                    <td class="px-6 py-4 border-l border-gray-100 text-center">
                                        @if($isStock)
                                            <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1.5 rounded-full
                                                {{ $inStock ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-600' }}">
                                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                                {{ $value }}
                                            </span>
                                        @else
                                            <span class="text-sm font-semibold text-gray-800">{{ $value }}</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Clear Compare -->
            <div class="text-center mt-6">
                <a href="{{ route('compare.index') }}" class="text-sm text-gray-400 hover:text-gray-600 transition-colors">
                    ✕ Clear comparison
                </a>
            </div>
        @endif

        <!-- Browse More -->
        <div class="mt-12 text-center">
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors group">
                Browse all phones
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

    </div>
</div>
@endsection
