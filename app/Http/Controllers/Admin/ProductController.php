<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Condition;
use App\Models\PhoneModel;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'brand_id', 'condition_id', 'status']);

        $products = Product::with(['phoneModel.brand', 'condition'])
            ->when($filters['search'] ?? null, function ($q, $search) {
                $q->where(function ($q2) use ($search) {
                    $q2->where('title', 'like', "%{$search}%")
                       ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($filters['brand_id'] ?? null, function ($q, $brandId) {
                $q->whereHas('phoneModel', fn ($q2) => $q2->where('brand_id', $brandId));
            })
            ->when($filters['condition_id'] ?? null, function ($q, $conditionId) {
                $q->where('condition_id', $conditionId);
            })
            ->when(isset($filters['status']) && $filters['status'] !== '', function ($q) use ($filters) {
                $q->where('is_active', (bool) $filters['status']);
            })
            ->latest()
            ->paginate(10)
            ->appends($filters);

        $brands     = Brand::orderBy('name')->get();
        $conditions = Condition::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'brands', 'conditions', 'filters'));
    }

    public function create()
    {
        $brands = Brand::with('phoneModels')->get();
        $conditions = Condition::all();
        return view('admin.products.create', compact('brands', 'conditions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone_model_id' => 'required|exists:phone_models,id',
            'condition_id' => 'required|exists:conditions,id',
            'title' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'storage' => 'required|string|max:50',
            'color' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products,sku|max:100',
            'warranty_months' => 'required|integer|min:0',
            'whats_in_box' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_available' => 'boolean',
            'primary_image' => 'required|image|max:2048',
            'product_images.*' => 'nullable|image|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_available'] = $request->has('is_available');
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated['price'] = $validated['base_price'];
        $validated['published_at'] = now();

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
        $conditions = Condition::all();
        return view('admin.products.edit', compact('product', 'brands', 'conditions'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'phone_model_id' => 'required|exists:phone_models,id',
            'condition_id' => 'required|exists:conditions,id',
            'title' => 'required|string|max:255',
            'base_price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'storage' => 'required|string|max:50',
            'color' => 'required|string|max:50',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'warranty_months' => 'required|integer|min:0',
            'whats_in_box' => 'nullable|string',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_available' => 'boolean',
            'primary_image' => 'nullable|image|max:20480',
            'product_images.*' => 'nullable|image|max:20480',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_available'] = $request->has('is_available');
        $validated['price'] = $validated['base_price'];

        // Only update slug if title changed
        if ($product->title !== $validated['title']) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], $product->id);
        }

        // Remove images from $validated so they don't overwrite as NULL
        unset($validated['primary_image'], $validated['product_images']);

        // Handle Primary Image
        if ($request->hasFile('primary_image')) {
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
