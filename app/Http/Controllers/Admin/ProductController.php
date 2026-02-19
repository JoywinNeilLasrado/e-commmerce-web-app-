<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\PhoneModel;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['phoneModel.brand', 'variants'])
            ->latest()
            ->paginate(10);
            
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $brands = Brand::with('phoneModels')->get();
        return view('admin.products.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone_model_id' => 'required|exists:phone_models,id',
            'title' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'warranty_months' => 'required|integer|min:0',
            'whats_in_box' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'primary_image' => 'required|image|max:2048', // Max 2MB
            'product_images.*' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        // Handle Primary Image
        if ($request->hasFile('primary_image')) {
            $path = $request->file('primary_image')->store('products', 'public');
            $validated['primary_image'] = $path;
        }

        $product = Product::create($validated);

        // Handle Gallery Images
        if ($request->hasFile('product_images')) {
            foreach ($request->file('product_images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $brands = Brand::with('phoneModels')->get();
        return view('admin.products.edit', compact('product', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'phone_model_id' => 'required|exists:phone_models,id',
            'title' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'warranty_months' => 'required|integer|min:0',
            'whats_in_box' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'primary_image' => 'nullable|image|max:2048', // Max 2MB
            'product_images.*' => 'nullable|image|max:2048',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        // Handle Primary Image
        if ($request->hasFile('primary_image')) {
            // Delete old image if it's not a URL
            if ($product->primary_image && !Str::startsWith($product->primary_image, 'http')) {
                Storage::disk('public')->delete($product->primary_image);
            }
            $path = $request->file('primary_image')->store('products', 'public');
            $validated['primary_image'] = $path;
        }

        $product->update($validated);

        // Handle Gallery Images (Append)
        if ($request->hasFile('product_images')) {
            foreach ($request->file('product_images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'sort_order' => $product->images()->max('sort_order') + 1 + $index,
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function destroyImage(ProductImage $productImage)
    {
        // Delete file from storage
        if (!Str::startsWith($productImage->image_path, 'http')) {
            Storage::disk('public')->delete($productImage->image_path);
        }

        $productImage->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}
