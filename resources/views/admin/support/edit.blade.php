@extends('layouts.admin')

@section('title', 'Edit: ' . $supportPage->title)

@section('content')
@php
    $meta = [
        'warranty' => ['accent'=>'#6366f1','icon'=>'🛡️'],
        'returns'  => ['accent'=>'#10b981','icon'=>'↩️'],
        'shipping' => ['accent'=>'#3b82f6','icon'=>'🚚'],
        'contact'  => ['accent'=>'#8b5cf6','icon'=>'💬'],
    ];
    $accent = $meta[$supportPage->slug]['accent'] ?? '#374151';
    $icon   = $meta[$supportPage->slug]['icon']   ?? '📄';
@endphp
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="h-1 w-full" style="background: {{ $accent }};"></div>
            <div class="px-6 py-4 flex items-center gap-4">
                <a href="{{ route('admin.support.index') }}"
                   class="p-2 rounded-lg hover:bg-gray-100 transition text-gray-400 hover:text-gray-700 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-xl bg-gray-50 border border-gray-100 flex-shrink-0">
                    {{ $icon }}
                </div>
                <div class="flex-1 min-w-0">
                    <h1 class="text-lg font-bold text-gray-900 truncate">{{ $supportPage->title }}</h1>
                    <p class="text-xs text-gray-400 mt-0.5">Changes are published instantly to the live page.</p>
                </div>
                <a href="{{ route('support.'.$supportPage->slug) }}" target="_blank"
                   class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-600 bg-gray-50 border border-gray-200 px-3.5 py-2 rounded-xl hover:bg-gray-100 transition flex-shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    Preview
                </a>
            </div>
        </div>

        <form action="{{ route('admin.support.update', $supportPage) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-5">

                {{-- Title & Meta --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-md bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-600">1</span>
                        Page Info
                    </h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1.5">Page Title</label>
                            <input type="text" name="title" value="{{ old('title', $supportPage->title) }}"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-gray-50 focus:outline-none focus:border-blue-500 focus:bg-white transition-all">
                            @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1.5">
                                Meta Description
                                <span class="normal-case font-normal text-gray-400">(shown in search results)</span>
                            </label>
                            <input type="text" name="meta_description" value="{{ old('meta_description', $supportPage->meta_description) }}"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-gray-50 focus:outline-none focus:border-blue-500 focus:bg-white transition-all"
                                   placeholder="Short description for SEO…">
                            @error('meta_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex items-center justify-between py-2.5 px-4 bg-gray-50 rounded-xl border border-gray-200">
                            <div>
                                <p class="text-sm font-medium text-gray-700">Page Active</p>
                                <p class="text-xs text-gray-400">When off, the page returns a 404</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                                       {{ old('is_active', $supportPage->is_active) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600 peer-focus:ring-2 peer-focus:ring-blue-300 transition-all after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full"></div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Content Editor --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-semibold text-gray-900 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-md bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-600">2</span>
                            Page Content
                        </h2>
                        <span class="text-xs text-gray-400 bg-gray-50 px-2.5 py-1 rounded-full border border-gray-200">HTML supported</span>
                    </div>

                    {{-- Simple HTML toolbar --}}
                    <div class="flex flex-wrap gap-2 mb-3 p-2 bg-gray-50 rounded-xl border border-gray-200">
                        @foreach([
                            ['<h2>','H2','<h2>Heading</h2>'],
                            ['<h3>','H3','<h3>Sub-heading</h3>'],
                            ['<p>','Para','<p>Paragraph text here.</p>'],
                            ['<strong>','Bold','<strong>bold text</strong>'],
                            ['<ul><li>','List','<ul><li>Item 1</li><li>Item 2</li></ul>'],
                            ['<ol><li>','Num','<ol><li>Step 1</li><li>Step 2</li></ol>'],
                            ['<a','Link','<a href="#">Link text</a>'],
                        ] as [$tag, $label, $snippet])
                        <button type="button"
                                onclick="insertSnippet(`{{ $snippet }}`)"
                                class="px-2.5 py-1 text-xs font-medium bg-white text-gray-600 border border-gray-200 rounded-lg hover:bg-blue-50 hover:text-blue-700 hover:border-blue-300 transition">
                            {{ $label }}
                        </button>
                        @endforeach
                    </div>

                    <textarea id="content-editor" name="content" rows="20"
                              class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-mono bg-gray-50 focus:outline-none focus:border-blue-500 focus:bg-white transition-all leading-relaxed"
                              style="resize:vertical;">{{ old('content', $supportPage->content) }}</textarea>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-400 mt-2">Use standard HTML tags. The content is rendered directly on the public page.</p>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3 justify-end">
                    <a href="{{ route('admin.support.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Cancel
                    </a>
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white bg-gray-900 hover:bg-gray-700 rounded-xl shadow-sm hover:shadow-md transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Save Changes
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
function insertSnippet(text) {
    const ta = document.getElementById('content-editor');
    const start = ta.selectionStart, end = ta.selectionEnd;
    ta.value = ta.value.substring(0, start) + '\n' + text + '\n' + ta.value.substring(end);
    ta.selectionStart = ta.selectionEnd = start + text.length + 2;
    ta.focus();
}
</script>
@endsection
