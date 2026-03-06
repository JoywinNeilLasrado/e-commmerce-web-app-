@extends('layouts.app')

@section('title', $page->title . ' — PhoneShop')

@section('content')
<div>

    {{-- Hero --}}
    <div style="background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%); padding: 4rem 1rem 5rem;">
        <div class="max-w-4xl mx-auto text-center">
            <div style="width:4rem;height:4rem;background:rgba(255,255,255,0.1);border-radius:1rem;display:flex;align-items:center;justify-content:center;font-size:2rem;margin:0 auto 1.25rem;">🛡️</div>
            <h1 class="text-4xl font-extrabold text-white mb-3 tracking-tight">{{ $page->title }}</h1>
            @if($page->meta_description)
            <p class="text-indigo-200 text-lg max-w-xl mx-auto">{{ $page->meta_description }}</p>
            @endif
        </div>
    </div>

    {{-- Dynamic DB Content --}}
    <div class="bg-gray-50 -mt-6 pt-10 pb-20" style="border-radius:1.5rem 1.5rem 0 0;">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 mb-8"
                 style="line-height:1.75;">
                <style>
                    .page-content h2 { font-size:1.25rem; font-weight:700; color:#111827; margin: 1.5rem 0 .75rem; }
                    .page-content h3 { font-size:1rem; font-weight:600; color:#1f2937; margin: 1rem 0 .5rem; }
                    .page-content p  { font-size:.9rem; color:#4b5563; margin-bottom:.75rem; }
                    .page-content ul,.page-content ol { padding-left:1.25rem; margin-bottom:.75rem; }
                    .page-content li { font-size:.9rem; color:#4b5563; margin-bottom:.35rem; }
                    .page-content ul { list-style-type: disc; }
                    .page-content ol { list-style-type: decimal; }
                    .page-content strong { font-weight:600; color:#1f2937; }
                    .page-content a { color:#2563eb; }
                </style>
                <div class="page-content">{!! $page->content !!}</div>
            </div>
            <div class="text-center">
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
