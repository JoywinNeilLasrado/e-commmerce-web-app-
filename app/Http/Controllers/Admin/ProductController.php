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
            'original_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'warranty_months' => 'required|integer|min:0',
            'whats_in_box' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'primary_image' => 'required|image|max:2048', // Max 2MB
            'product_images.*' => 'nullable|image|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);

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
            'original_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'warranty_months' => 'required|integer|min:0',
            'whats_in_box' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'primary_image' => 'nullable|image|max:20480', // Max 20MB
            'product_images.*' => 'nullable|image|max:20480',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');

        // Only update slug if title changed, to preserve existing links
        if ($product->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $product->id);
        }

        // Remove images from $validated so they don't overwrite as NULL if no file is uploaded
        unset($validated['primary_image'], $validated['product_images']);

        // Handle Primary Image
        if ($request->hasFile('primary_image')) {
            // Delete old image if it's a local file (not an external URL)
            if ($product->primary_image && !Str::startsWith($product->primary_image, 'http')) {
                Storage::disk('public')->delete($product->primary_image);
            }
            $path = $request->file('primary_image')->store('products', 'public');
            $validated['primary_image'] = $path;
        }

        $product->update($validated);

        // Handle Gallery Images (Append)
        if ($request->hasFile('product_images')) {
            $allImages = $request->file('product_images');
            $filesToProcess = [];
            
            // Flatten the array in case multiple inputs were used (multi-selection fix)
            foreach ($allImages as $item) {
                if (is_array($item)) {
                    $filesToProcess = array_merge($filesToProcess, $item);
                } elseif ($item) {
                    $filesToProcess[] = $item;
                }
            }

            foreach ($filesToProcess as $index => $image) {
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

    private function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Product::where('slug', $slug)
            ->when($ignoreId, function ($query, $id) {
                return $query->where('id', '!=', $id);
            })
            ->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
