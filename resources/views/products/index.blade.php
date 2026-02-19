@extends('layouts.app')

@section('title', 'All Phones — PhoneShop')

@section('content')
<div class="bg-gray-50 min-h-screen pt-24 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 fade-in-section">
            <div>
                <h1 class="text-3xl font-black text-gray-900">
                    @if(request('search'))
                        Results for "{{ request('search') }}"
                    @else
                        All Phones
                    @endif
                </h1>
                <p class="text-sm text-gray-500 mt-1">{{ $products->total() }} certified refurbished devices found</p>
            </div>
            <div class="flex items-center gap-3">
                <label class="text-sm font-medium text-gray-600">Sort by:</label>
                <select onchange="window.location.href=this.value"
                        class="bg-white border border-gray-200 rounded-xl py-2.5 px-4 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400 shadow-sm">
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                </select>
            </div>
        </div>

        <div class="lg:grid lg:grid-cols-4 lg:gap-8">
            <!-- Sidebar Filters -->
            <aside class="hidden lg:block space-y-8 fade-in-section">
                <!-- Brand Filter -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-5">Brand</h3>
                    <div class="space-y-2">
                        <a href="{{ route('products.index', request()->except('brand')) }}"
                           class="flex items-center justify-between px-3 py-2 rounded-xl text-sm font-medium transition-all {{ !request('brand') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            All Brands
                            @if(!request('brand'))<span class="w-2 h-2 bg-blue-500 rounded-full"></span>@endif
                        </a>
                        @foreach($brands as $brand)
                            <a href="{{ route('products.index', ['brand' => $brand->slug] + request()->except('brand')) }}"
                               class="flex items-center justify-between px-3 py-2 rounded-xl text-sm font-medium transition-all {{ request('brand') == $brand->slug ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                                {{ $brand->name }}
                                @if(request('brand') == $brand->slug)<span class="w-2 h-2 bg-blue-500 rounded-full"></span>@endif
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-5">Price Range</h3>
                    <form action="{{ route('products.index') }}" method="GET" class="space-y-4">
                        @foreach(request()->except(['min_price', 'max_price']) as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Min (₹)</label>
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0"
                                       class="w-full border border-gray-200 rounded-xl p-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-1">Max (₹)</label>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Any"
                                       class="w-full border border-gray-200 rounded-xl p-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/30 focus:border-blue-400">
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl text-sm transition-all duration-200 shadow-md shadow-blue-600/20">
                            Apply Filter
                        </button>
                    </form>
                </div>

                <!-- Condition Filter -->
                <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-5">Condition</h3>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="w-4 h-4 border-2 border-emerald-400 rounded bg-emerald-50 flex items-center justify-center">
                                <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Excellent</span>
                            <span class="ml-auto text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">Best</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="w-4 h-4 border-2 border-blue-400 rounded bg-blue-50 flex items-center justify-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Good</span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="w-4 h-4 border-2 border-amber-400 rounded bg-amber-50 flex items-center justify-center">
                                <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Fair</span>
                            <span class="ml-auto text-[10px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full">Budget</span>
                        </label>
                    </div>
                </div>

                <!-- Clear Filters -->
                @if(request()->hasAny(['brand', 'min_price', 'max_price', 'search']))
                    <a href="{{ route('products.index') }}" class="flex items-center justify-center gap-2 w-full py-2.5 border-2 border-dashed border-gray-200 rounded-xl text-sm font-medium text-gray-500 hover:border-red-300 hover:text-red-500 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Clear All Filters
                    </a>
                @endif
            </aside>

            <!-- Product Grid -->
            <div class="mt-6 lg:mt-0 lg:col-span-3">
                @if($products->isEmpty())
                    <div class="text-center py-24 bg-white rounded-2xl border border-gray-100 shadow-sm">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No phones found</h3>
                        <p class="text-gray-500 text-sm mb-8">Try adjusting your filters or search terms.</p>
                        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white font-bold px-6 py-3 rounded-xl hover:bg-blue-700 transition-all shadow-md shadow-blue-600/20">
                            Clear filters
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                        @foreach($products as $product)
                            <div class="fade-in-section" style="transition-delay: {{ ($loop->iteration % 6) * 60 }}ms">
                                <x-product-card :product="$product" />
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
