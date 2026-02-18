<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $cart = Cart::with(['items.productVariant.product', 'items.productVariant.condition'])
            ->firstOrCreate(['user_id' => $user->id]);

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $addresses = $user->addresses;

        return view('checkout.index', compact('cart', 'addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:card,upi,cod',
        ]);

        $user = Auth::user();
        $cart = Cart::with('items.productVariant')->where('user_id', $user->id)->firstOrFail();

        if ($cart->items->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Check stock one last time
        foreach ($cart->items as $item) {
            if ($item->productVariant->stock < $item->quantity) {
                 return back()->with('error', 'Some items in your cart are no longer available in the requested quantity.');
            }
        }

        try {
            DB::beginTransaction();

            // Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $request->address_id,
                'status' => 'pending',
                'subtotal' => $cart->total,
                'total' => $cart->total,
                'order_number' => 'ORD-' . strtoupper(uniqid()),
            ]);

            // Create Order Items and Decrease Stock
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                    'phone_title' => $item->productVariant->product->title,
                    'storage' => $item->productVariant->storage,
                    'color' => $item->productVariant->color,
                    'condition' => $item->productVariant->condition->name,
                ]);

                // Decrease stock
                $item->productVariant->decrement('stock', $item->quantity);
            }

            // Simulated Payment
            $paymentStatus = $request->payment_method === 'cod' ? 'pending' : 'completed';
            Payment::create([
                'order_id' => $order->id,
                'transaction_id' => 'TXN-' . strtoupper(uniqid()) . '-SIM',
                'amount' => $cart->total,
                'payment_method' => $request->payment_method,
                'status' => $paymentStatus,
                'paid_at' => $paymentStatus === 'completed' ? now() : null,
            ]);

            if ($paymentStatus === 'completed') {
                $order->update([
                    'status' => 'processing',
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                ]);
            }

            // Clear Cart
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            dd(explode('(SQL:', $e->getMessage())[0]);
            return back()->with('error', 'Failed to place order. Please try again. ' . $e->getMessage());
        }
    }
}
