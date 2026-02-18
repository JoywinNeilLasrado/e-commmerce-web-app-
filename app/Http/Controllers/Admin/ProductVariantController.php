<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
{
    public function index(Product $product)
    {
        $variants = $product->variants()->with('condition')->get();
        return view('admin.products.variants.index', compact('product', 'variants'));
    }

    public function create(Product $product)
    {
        $conditions = \App\Models\Condition::all();
        return view('admin.products.variants.create', compact('product', 'conditions'));
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'condition_id' => 'required|exists:conditions,id',
            'color' => 'required|string|max:50',
            'storage' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:product_variants,sku|max:100',
            'is_available' => 'boolean',
        ]);

        $validated['is_available'] = $request->has('is_available');

        $product->variants()->create($validated);

        return redirect()->route('admin.products.variants.index', $product)
            ->with('success', 'Variant added successfully.');
    }

    public function edit(Product $product, ProductVariant $variant)
    {
        $conditions = \App\Models\Condition::all();
        return view('admin.products.variants.edit', compact('product', 'variant', 'conditions'));
    }

    public function update(Request $request, Product $product, ProductVariant $variant)
    {
        $validated = $request->validate([
            'condition_id' => 'required|exists:conditions,id',
            'color' => 'required|string|max:50',
            'storage' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|max:100|unique:product_variants,sku,' . $variant->id,
            'is_available' => 'boolean',
        ]);

        $validated['is_available'] = $request->has('is_available');

        $variant->update($validated);

        return redirect()->route('admin.products.variants.index', $product)
            ->with('success', 'Variant updated successfully.');
    }

    public function destroy(Product $product, ProductVariant $variant)
    {
        $variant->delete();
        return redirect()->route('admin.products.variants.index', $product)
            ->with('success', 'Variant deleted successfully.');
    }
}
