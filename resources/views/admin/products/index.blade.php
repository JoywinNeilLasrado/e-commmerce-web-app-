@extends('layouts.admin')

@section('title', 'Manage Products - Admin Dashboard')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Manage Products</h1>
            <a href="{{ route('admin.products.create') }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800">
                + Add New Product
            </a>
        </div>

        {{-- Filter Bar --}}
        <form method="GET" action="{{ route('admin.products.index') }}"
              class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">

                {{-- Search --}}
                <div class="lg:col-span-2">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                           placeholder="Product name or SKU…"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                </div>

                {{-- Brand --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Brand</label>
                    <select name="brand_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 bg-white">
                        <option value="">All Brands</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ ($filters['brand_id'] ?? '') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Condition --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Condition</label>
                    <select name="condition_id"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 bg-white">
                        <option value="">All Conditions</option>
                        @foreach($conditions as $condition)
                            <option value="{{ $condition->id }}" {{ ($filters['condition_id'] ?? '') == $condition->id ? 'selected' : '' }}>
                                {{ $condition->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                    <select name="status"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400 bg-white">
                        <option value="">All</option>
                        <option value="1" {{ ($filters['status'] ?? '') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ isset($filters['status']) && $filters['status'] === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>

            {{-- Actions Row --}}
            <div class="flex items-center gap-3 mt-3">
                <button type="submit"
                        class="bg-gray-900 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-gray-700 transition">
                    🔍 Filter
                </button>
                @if(array_filter($filters))
                    <a href="{{ route('admin.products.index') }}"
                       class="text-sm text-red-500 hover:text-red-700 font-medium transition">
                        ✕ Clear filters
                    </a>
                @endif
                <span class="ml-auto text-xs text-gray-400">
                    {{ $products->total() }} product{{ $products->total() !== 1 ? 's' : '' }} found
                </span>
            </div>
        </form>

        {{-- Success Flash --}}
        @if(session('success'))
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand / Model</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0 bg-gray-100 rounded-full flex items-center justify-center text-xl overflow-hidden">
                                        @if($product->primary_image_url)
                                            <img src="{{ $product->primary_image_url }}" alt="" class="w-full h-full object-cover">
                                        @else
                                            📱
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $product->title }}</div>
                                        @if($product->sku)
                                            <div class="text-xs text-gray-400 font-mono">{{ $product->sku }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded bg-gray-50 border border-gray-100 flex items-center justify-center p-1 overflow-hidden flex-shrink-0">
                                        <img src="{{ $product->phoneModel->brand->logo_url }}" alt="{{ $product->phoneModel->brand->name }}" class="max-w-full max-h-full object-contain">
                                    </div>
                                    <div class="text-sm text-gray-900 font-medium">{{ $product->phoneModel->brand->name }}</div>
                                </div>
                                <div class="text-xs text-gray-500 mt-0.5 ml-11">{{ $product->phoneModel->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-wrap gap-1">
                                    @if($product->storage)
                                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">{{ $product->storage }}</span>
                                    @endif
                                    @if($product->color)
                                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">{{ $product->color }}</span>
                                    @endif
                                    @if($product->condition)
                                        <span class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full">{{ $product->condition->name }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                ₹{{ number_format($product->price, 0) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold {{ $product->stock > 0 ? 'text-gray-900' : 'text-red-600' }}">
                                    {{ $product->stock }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                <div class="text-4xl mb-2">🔍</div>
                                <div class="text-sm font-medium">No products found</div>
                                @if(array_filter($filters))
                                    <a href="{{ route('admin.products.index') }}" class="text-blue-500 hover:underline text-xs mt-1 inline-block">Clear filters</a>
                                @endif
                            </td>
                        </tr>
                    @endempty
                </tbody>
            </table>
            <div class="p-4 border-t border-gray-200">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
