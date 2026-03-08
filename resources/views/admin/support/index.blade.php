@extends('layouts.admin')

@section('title', 'Support Pages')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Support Pages</h1>
            <p class="text-sm text-gray-500 mt-1">Manage the content of your public-facing support pages.</p>
        </div>

        {{-- Cards Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            @php
                $meta = [
                    'warranty' => [
                        'accent' => '#6366f1',
                        'label'  => 'Warranty Policy',
                        'url'    => '/warranty-policy',
                        'svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
                    ],
                    'returns'  => [
                        'accent' => '#10b981',
                        'label'  => 'Returns & Refunds',
                        'url'    => '/returns-refunds',
                        'svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>',
                    ],
                    'shipping' => [
                        'accent' => '#3b82f6',
                        'label'  => 'Shipping Info',
                        'url'    => '/shipping-info',
                        'svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>',
                    ],
                    'contact'  => [
                        'accent' => '#8b5cf6',
                        'label'  => 'Contact Us',
                        'url'    => '/contact',
                        'svg'    => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>',
                    ],
                ];
            @endphp

            @foreach($pages as $page)
            @php
                $m      = $meta[$page->slug] ?? ['accent'=>'#374151','label'=>$page->title,'url'=>'/'.$page->slug,'svg'=>'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>'];
                $accent = $m['accent'];
            @endphp
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex flex-col">

                {{-- Accent stripe --}}
                <div class="h-1 w-full" style="background: {{ $accent }};"></div>

                <div class="p-6 flex-1 flex flex-col">

                    {{-- Icon + Title row --}}
                    <div class="flex items-start justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3.5">
                            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0 border border-gray-100"
                                 style="background: {{ $accent }}18;">
                                <svg class="w-5 h-5" style="color: {{ $accent }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $m['svg'] !!}
                                </svg>
                            </div>
                            <div>
                                <h2 class="font-bold text-gray-900 text-[15px] leading-tight">{{ $page->title }}</h2>
                                <code class="text-xs text-gray-400 font-mono">{{ $m['url'] }}</code>
                            </div>
                        </div>

                        {{-- Toggle button --}}
                        <form action="{{ route('admin.support.toggle', $page) }}" method="POST" class="flex-shrink-0 mt-0.5">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    title="{{ $page->is_active ? 'Click to deactivate' : 'Click to activate' }}"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold cursor-pointer transition-all hover:opacity-80
                                        {{ $page->is_active
                                            ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200 hover:bg-red-50 hover:text-red-600 hover:ring-red-200'
                                            : 'bg-red-50 text-red-600 ring-1 ring-red-200 hover:bg-emerald-50 hover:text-emerald-700 hover:ring-emerald-200' }}">
                                <span class="w-1.5 h-1.5 rounded-full inline-block {{ $page->is_active ? 'bg-emerald-500' : 'bg-red-400' }}"></span>
                                {{ $page->is_active ? 'Active' : 'Hidden' }}
                            </button>
                        </form>
                    </div>

                    {{-- Meta description --}}
                    @if($page->meta_description)
                    <p class="text-sm text-gray-500 leading-relaxed line-clamp-2 flex-1 mb-5">{{ $page->meta_description }}</p>
                    @else
                    <p class="text-sm text-gray-300 italic flex-1 mb-5">No meta description set.</p>
                    @endif

                    {{-- Actions --}}
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.support.edit', $page) }}"
                           class="flex-1 inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-sm font-semibold text-white bg-gray-900 hover:bg-gray-700 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Content
                        </a>
                        <a href="{{ route('support.'.$page->slug) }}" target="_blank"
                           class="inline-flex items-center justify-center gap-1.5 py-2.5 px-4 rounded-xl text-sm font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 border border-gray-200 hover:border-gray-300 transition-all whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            <span>Preview</span>
                        </a>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-100">
                    <span class="text-xs text-gray-400">
                        Updated {{ $page->updated_at->format('d M Y') }} at {{ $page->updated_at->format('h:i A') }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection
