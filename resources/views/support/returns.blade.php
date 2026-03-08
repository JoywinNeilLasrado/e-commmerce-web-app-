@extends('layouts.app')

@section('title', $page->title . ' — PhoneShop')

@section('content')
<div class="bg-[#F0FAFE] min-h-screen">
    <div class="bg-transparent border-b border-gray-100 py-16">
        <div class="max-w-4xl mx-auto px-4 text-center mt-6">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gray-50 text-gray-900 border border-gray-200 mb-6 shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
            </div>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-4 tracking-tight">{{ $page->title }}</h1>
            @if($page->meta_description)
            <p class="text-gray-500 text-lg max-w-xl mx-auto">{{ $page->meta_description }}</p>
            @endif
        </div>
    </div>
    <div class="bg-transparent py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 mb-8">
                <style>
                    .page-content h2 { font-size:1.25rem; font-weight:700; color:#111827; margin: 1.5rem 0 .75rem; }
                    .page-content h3 { font-size:1rem; font-weight:600; color:#1f2937; margin: 1rem 0 .5rem; }
                    .page-content p  { font-size:.9rem; color:#4b5563; margin-bottom:.75rem; }
                    .page-content ul,.page-content ol { padding-left:1.25rem; margin-bottom:.75rem; }
                    .page-content li { font-size:.9rem; color:#4b5563; margin-bottom:.35rem; }
                    .page-content ul { list-style-type: disc; }
                    .page-content ol { list-style-type: decimal; }
                    .page-content strong { font-weight:600; color:#1f2937; }
                </style>
                <div class="page-content">{!! $page->content !!}</div>
            </div>
            <div class="text-center">
                <a href="{{ route('support.contact') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-semibold text-white text-sm bg-gray-900 hover:bg-black transition-colors shadow-lg shadow-gray-900/20">
                    Contact Us to Return
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
