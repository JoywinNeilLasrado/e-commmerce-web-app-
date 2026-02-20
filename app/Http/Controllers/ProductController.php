<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Condition;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['phoneModel.brand', 'variants'])
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->whereHas('variants', function ($q) {
                $q->where('stock', '>', 0);
            });

        // Filter by brand
        if ($request->filled('brand')) {
            $query->whereHas('phoneModel.brand', function ($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%') // Search Description
                  ->orWhereHas('phoneModel', function ($query) use ($request) {
                      $query->where('name', 'like', '%' . $request->search . '%')
                            ->orWhereHas('brand', function ($brandQuery) use ($request) { // Search Brand
                                $brandQuery->where('name', 'like', '%' . $request->search . '%');
                            });
                  });
            });
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderByRaw('base_price ASC');
                break;
            case 'price_high':
                $query->orderByRaw('base_price DESC');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->latest('published_at');
        }

        $products = $query->paginate(12);
        $brands = Brand::where('is_active', true)->get();

        return view('products.index', compact('products', 'brands'));
    }

    public function show($slug)
    {
        $product = Product::with(['phoneModel.brand', 'images', 'variants.condition', 'reviews.user'])
            ->withCount('reviews')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get related products
        $relatedProducts = Product::with(['phoneModel.brand', 'variants'])
            ->where('phone_model_id', $product->phone_model_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}
