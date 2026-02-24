<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $products = Auth::user()->wishlistProducts()
            ->with(['phoneModel.brand', 'variants.condition'])
            ->latest()
            ->get();

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Wishlist viewed Successfully',
                'products' => $products
            ]);
        }
        return view('wishlist.index', compact('products'));
    }

    public function toggle(Product $product)
    {
        $user = Auth::user();
        $wishlist = $user->wishlists()->where('product_id', $product->id)->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
            $message = 'Removed from wishlist.';
        } else {
            $user->wishlists()->create(['product_id' => $product->id]);
            $status = 'added';
            $message = 'Added to wishlist.';
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'status' => $status,
                'message' => $message,
                'count' => $user->wishlists()->count()
            ]);
        }

        

        return back()->with('success', $message);
    }
}
