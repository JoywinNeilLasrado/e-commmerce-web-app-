<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index(Request $request)
    {
        $cart = Cart::with(['items.productVariant.product', 'items.productVariant.condition'])
            ->firstOrCreate(['user_id' => Auth::id()]);

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart viewed Successfully',
                'cart' => $cart
            ]);
        }
        return view('cart.index', compact('cart'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $variant = ProductVariant::find($request->variant_id);

        if (!$variant->is_available || $variant->stock < $request->quantity) {
            if ($request->routeIs('api.*') || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not available in requested quantity.'
                ], 422);
            }
            return back()->with('error', 'Product not available in requested quantity.');
        }

        $cartItem = $cart->items()->where('product_variant_id', $variant->id)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cart->items()->create([
                'product_variant_id' => $variant->id,
                'quantity' => $request->quantity,
                'price' => $variant->price,
            ]);
        }

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart.',
                'cart_item' => $cartItem ?? $cart->items()->where('product_variant_id', $variant->id)->latest()->first()
            ]);
        }

        if ($request->input('action') === 'buy_now') {
            return redirect()->route('checkout.index');
        }

        return redirect()->route('cart.index')->with('success', 'Item added to cart.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $variant = $cartItem->productVariant;

        if ($variant->stock < $request->quantity) {
             if ($request->routeIs('api.*') || $request->wantsJson()) {
                 return response()->json([
                     'success' => false,
                     'message' => 'Requested quantity exceeds stock.'
                 ], 422);
             }
             return back()->with('error', 'Requested quantity exceeds stock.');
        }

        $cartItem->update(['quantity' => $request->quantity]);

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated.',
                'cart_item' => $cartItem->fresh(['productVariant.product', 'productVariant.condition'])
            ]);
        }

        return back()->with('success', 'Cart updated.');
    }

    public function destroy(CartItem $cartItem)
    {
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cartItem->delete();

        if (request()->routeIs('api.*') || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart.'
            ]);
        }

        return back()->with('success', 'Item removed from cart.');
    }
}
