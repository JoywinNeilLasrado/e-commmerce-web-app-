@extends('layouts.app')

@section('title', 'Products - Refurbished Phones Shop')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Our Collection</h1>
                <p class="mt-2 text-sm text-gray-500">Premium refurbished devices tested to perfection.</p>
            </div>
            <div class="mt-4 md:mt-0 flex items-center space-x-4">
                <span class="text-sm text-gray-500">Showing {{ $products->firstItem() }} - {{ $products->lastItem() }} of {{ $products->total() }} results</span>
                <select onchange="window.location.href=this.value" class="bg-white border-gray-300 rounded-md py-2 px-4 text-sm focus:ring-indigo-500">
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                </select>
            </div>
        </div>

        <div class="lg:grid lg:grid-cols-4 lg:gap-x-8">
            <!-- Filters -->
            <aside class="hidden lg:block">
                <h2 class="sr-only">Filters</h2>
                <div class="space-y-10">
                    <!-- Brand Filter -->
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Brands</h3>
                        <div class="mt-4 space-y-2">
                             @foreach($brands as $brand)
                                <div class="flex items-center">
                                    <a href="{{ route('products.index', ['brand' => $brand->slug] + request()->except('brand')) }}" 
                                       class="text-sm hover:text-indigo-600 {{ request('brand') == $brand->slug ? 'text-indigo-600 font-bold' : 'text-gray-600' }}">
                                        {{ $brand->name }}
                                    </a>
                                </div>
                             @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Price Range</h3>
                        <form action="{{ route('products.index') }}" method="GET" class="mt-4 space-y-4">
                            @foreach(request()->except(['min_price', 'max_price']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            <div class="flex items-center space-x-2">
                                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min" class="w-full border-gray-300 rounded-md p-2 text-sm">
                                <span class="text-gray-400">-</span>
                                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max" class="w-full border-gray-300 rounded-md p-2 text-sm">
                            </div>
                            <button type="submit" class="w-full bg-indigo-600 text-white rounded-md py-2 text-sm font-medium hover:bg-indigo-700">Apply</button>
                        </form>
                    </div>

                    <!-- Condition Grade -->
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Condition</h3>
                        <div class="mt-4 space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-600">Excellent</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-600">Good</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-600">Fair</span>
                            </label>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Product Grid -->
            <div class="mt-6 lg:mt-0 lg:col-span-3">
                @if($products->isEmpty())
                    <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-gray-100">
                        <span class="text-6xl mb-4 block">🔍</span>
                        <h3 class="text-lg font-medium text-gray-900">No products found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your filters or search terms.</p>
                        <a href="{{ route('products.index') }}" class="mt-6 inline-block text-indigo-600 font-medium hover:underline">Clear all filters</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 xl:gap-x-8">
                        @foreach($products as $product)
                            <x-product-card :product="$product" />
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
