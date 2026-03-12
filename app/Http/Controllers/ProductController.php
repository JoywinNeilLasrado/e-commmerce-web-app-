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
        $query = Product::with(['phoneModel.brand', 'condition'])
            ->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('stock', '>', 0);

        // Filter by brand
        if ($request->filled('brand')) {
            $query->whereHas('phoneModel.brand', function ($q) use ($request) {
                $q->where('slug', $request->brand);
            });
        }

        // Filter by condition
        if ($request->filled('condition')) {
            $conditionIds = is_array($request->condition) ? $request->condition : [$request->condition];
            $query->whereIn('condition_id', $conditionIds);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhereHas('phoneModel', function ($query) use ($request) {
                      $query->where('name', 'like', '%' . $request->search . '%')
                            ->orWhereHas('brand', function ($brandQuery) use ($request) {
                                $brandQuery->where('name', 'like', '%' . $request->search . '%');
                            });
                  });
            });
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderByRaw('price ASC');
                break;
            case 'price_high':
                $query->orderByRaw('price DESC');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->latest('published_at');
        }

        $products = $query->paginate(12);
        $brands = Brand::where('is_active', true)->get();
        $conditions = Condition::all();

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json([
                'message' => 'product page communicated successfully',
                'products' => $products,
                'brands' => $brands,
                'conditions' => $conditions
            ]);
        }

        return view('products.index', compact('products', 'brands', 'conditions'));
    }

    public function show($slug, Request $request)
    {
        $product = Product::with(['phoneModel.brand', 'images', 'condition', 'reviews.user'])
            ->withCount('reviews')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get related products
        $relatedProducts = Product::with(['phoneModel.brand', 'condition'])
            ->where('phone_model_id', $product->phone_model_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        $userReview = null;
        if (!$request->routeIs('api.*') && auth()->check()) {
            $userReview = $product->reviews()->where('user_id', auth()->id())->first();
        } elseif ($request->routeIs('api.*') && auth('api')->check()) {
            $userReview = $product->reviews()->where('user_id', auth('api')->id())->first();
        }

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json([
                'product' => $product,
                'relatedProducts' => $relatedProducts,
                'userReview' => $userReview
            ]);
        }

        return view('products.show', compact('product', 'relatedProducts', 'userReview'));
    }
}
