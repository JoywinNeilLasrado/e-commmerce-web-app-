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

    public function index(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::with(['items.product.condition', 'items.product.phoneModel.brand'])
            ->firstOrCreate(['user_id' => $user->id]);

        if ($cart->items->count() === 0) {
            if ($request->routeIs('api.*') || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty.'
                ], 400);
            }
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $addresses = $user->addresses;

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Checkout viewed Successfully',
                'cart' => $cart,
                'addresses' => $addresses
            ]);
        }

        return view('checkout.index', compact('cart', 'addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'address_id' => [
                'required',
                \Illuminate\Validation\Rule::exists('addresses', 'id')->where(function ($query) {
                    return $query->where('user_id', Auth::id());
                }),
            ],
            'payment_method' => 'required|in:cod,payu',
        ], [
            'address_id.exists' => 'The selected address is invalid or does not belong to you.',
        ]);

        $user = Auth::user();
        $cart = Cart::with('items.product')->where('user_id', $user->id)->firstOrFail();

        if ($cart->items->count() === 0) {
            if ($request->routeIs('api.*') || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty.'
                ], 400);
            }
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Check stock one last time
        foreach ($cart->items as $item) {
            if ($item->product->stock < $item->quantity) {
                 if ($request->routeIs('api.*') || $request->wantsJson()) {
                     return response()->json([
                         'success' => false,
                         'message' => 'Some items in your cart are no longer available in the requested quantity.'
                     ], 400);
                 }
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
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'subtotal' => $item->price * $item->quantity,
                    'phone_title' => $item->product->title,
                    'storage' => $item->product->storage,
                    'color' => $item->product->color,
                    'condition' => $item->product->condition->name ?? 'Refurbished',
                ]);

                // Decrease stock
                $item->product->decrement('stock', $item->quantity);
            }
            // Payment Processing

            if ($request->payment_method === 'payu') {
                $order->update(['status' => 'pending']);
                DB::commit();

                // PayU Configuration
                $key = config('services.payu.key');
                $salt = config('services.payu.salt');
                $txnid = $order->order_number;
                $amount = $order->total;
                $productinfo = 'Order #' . $order->order_number;
                $firstname = $user->name;
                $email = $user->email;
                $phone = $order->address->phone ?? '9999999999';
                $surl = route('payment.payu.response');
                $furl = route('payment.payu.response');
                
                $hashSequence = "$key|$txnid|$amount|$productinfo|$firstname|$email|||||||||||$salt";
                $hash = strtolower(hash('sha512', $hashSequence));

                $payuUrl = config('services.payu.test_mode') ? 'https://test.payu.in/_payment' : 'https://secure.payu.in/_payment';

                if ($request->routeIs('api.*') || $request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'PayU transaction initiated.',
                        'payment_parameters' => [
                            'key' => $key,
                            'txnid' => $txnid,
                            'amount' => (string)$amount,
                            'productinfo' => $productinfo,
                            'firstname' => $firstname,
                            'email' => $email,
                            'phone' => $phone,
                            'surl' => $surl,
                            'furl' => $furl,
                            'hash' => $hash,
                            'payuUrl' => $payuUrl,
                        ],
                        'order' => $order
                    ]);
                }

                return view('payment.payu_redirect', compact('key', 'txnid', 'amount', 'productinfo', 'firstname', 'email', 'phone', 'surl', 'furl', 'hash', 'payuUrl'));
            }

            $paymentStatus = $request->payment_method === 'cod' ? 'pending' : 'completed';
            
            Payment::create([
                'order_id' => $order->id,
                'transaction_id' => 'TXN-' . strtoupper(uniqid()) . '-COD',
                'amount' => $cart->total,
                'payment_method' => $request->payment_method,
                'status' => $paymentStatus,
                'paid_at' => $paymentStatus === 'completed' ? now() : null,
            ]);

            if ($paymentStatus === 'completed' || $request->payment_method === 'cod') {
                $order->update([
                    'status' => 'processing',
                    'payment_status' => $paymentStatus === 'completed' ? 'paid' : 'pending',
                    'paid_at' => $paymentStatus === 'completed' ? now() : null,
                ]);
            }

            // Clear Cart
            $cart->items()->delete();

            DB::commit();

            if ($request->routeIs('api.*') || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully!',
                    'order' => $order->load(['items', 'address'])
                ]);
            }

            return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->routeIs('api.*') || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to place order. ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Failed to place order. Please try again. ' . $e->getMessage());
        }
    }

    public function payuInitiate(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $user = Auth::user();
        $order = Order::where('id', $request->order_id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This order cannot be paid for in its current status.'
            ], 422);
        }

        // PayU Configuration
        $key = config('services.payu.key');
        $salt = config('services.payu.salt');
        $txnid = $order->order_number;
        $amount = $order->total;
        $productinfo = 'Order #' . $order->order_number;
        $firstname = $user->name;
        $email = $user->email;
        $phone = $order->address->phone ?? '9999999999';
        $surl = route('api.payment.payu.response');
        $furl = route('api.payment.payu.response');
        
        $hashSequence = "$key|$txnid|$amount|$productinfo|$firstname|$email|||||||||||$salt";
        $hash = strtolower(hash('sha512', $hashSequence));

        $payuUrl = config('services.payu.test_mode') ? 'https://test.payu.in/_payment' : 'https://secure.payu.in/_payment';

        return response()->json([
            'success' => true,
            'message' => 'PayU transaction parameters generated.',
            'payment_parameters' => [
                'key' => $key,
                'txnid' => $txnid,
                'amount' => (string)$amount,
                'productinfo' => $productinfo,
                'firstname' => $firstname,
                'email' => $email,
                'phone' => $phone,
                'surl' => $surl,
                'furl' => $furl,
                'hash' => $hash,
                'payuUrl' => $payuUrl,
            ],
            'order' => $order
        ]);
    }

    public function payuResponse(Request $request)
    {
        $key = config('services.payu.key');
        $salt = config('services.payu.salt');
        
        $status = $request->status;
        $firstname = $request->firstname;
        $amount = $request->amount;
        $txnid = $request->txnid;
        $posted_hash = $request->hash;
        $productinfo = $request->productinfo;
        $email = $request->email;
        
        $retHashSeq = "$salt|$status|||||||||||$email|$firstname|$productinfo|$amount|$txnid|$key";
        $hash = strtolower(hash('sha512', $retHashSeq));
        
        $order = Order::where('order_number', $txnid)->first();
        if (!$order) {
            if ($request->routeIs('api.*') || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found.'
                ], 404);
            }
            return redirect()->route('cart.index')->with('error', 'Order not found.');
        }

        if ($hash != $posted_hash) {
            DB::transaction(function () use ($order) {
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }
                $order->update(['status' => 'cancelled']);
            });
            
            if ($request->routeIs('api.*') || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid payment response. Please try again.'
                ], 400);
            }
            return redirect()->route('checkout.index')->with('error', 'Invalid payment response. Please try again.');
        }

        // Fix for Session Loss: Manually login user if hash is valid
        if (!Auth::check()) {
            Auth::loginUsingId($order->user_id);
        }

        if ($status == 'success') {
            
            Payment::create([
                'order_id' => $order->id,
                'transaction_id' => $request->mihpayid ?? $txnid,
                'amount' => $amount,
                'payment_method' => 'payu',
                'status' => 'completed',
                'paid_at' => now(),
                'payment_details' => array_merge($request->all(), [
                    'mode' => $request->mode,
                    'bankcode' => $request->bankcode,
                    'card_type' => $request->card_type,
                    'network_type' => $request->network_type,
                    'name_on_card' => $request->name_on_card,
                    'issuing_bank' => $request->issuing_bank,
                    'upi_va' => $request->field4, 
                    'error_message' => $request->error_Message,
                    'pg_type' => $request->PG_TYPE, 
                    'bank_ref_num' => $request->bank_ref_num,
                ]),
            ]);

            $order->update([
                'status' => 'processing',
                'payment_status' => 'paid',
                'paid_at' => now(),
            ]);

            // Clear Cart
            $carts = Cart::where('user_id', $order->user_id)->get();
            foreach ($carts as $c) {
                $c->items()->delete();
            }

            if ($request->routeIs('api.*') || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Payment successful! Your order has been placed.',
                    'order' => $order->load(['items', 'address', 'payment'])
                ]);
            }

            return redirect()->route('orders.show', $order)->with('success', 'Payment successful! Your order has been placed.');
        } else {
            // Payment Failed
             Payment::create([
                'order_id' => $order->id,
                'transaction_id' => $request->mihpayid ?? $txnid,
                'amount' => $amount,
                'payment_method' => 'payu',
                'status' => 'failed',
                'payment_details' => [
                    'error_message' => $request->error_Message,
                    'pg_type' => $request->PG_TYPE,
                ]
            ]);

            // Restore Stock and Cancel Order
            DB::transaction(function () use ($order) {
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->quantity);
                    }
                }
                $order->update(['status' => 'cancelled']);
            });
            
            if ($request->routeIs('api.*') || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment failed: ' . ($request->error_Message ?? 'Please try again.')
                ], 400);
            }
            
            return redirect()->route('checkout.index')->with('error', 'Payment failed: ' . ($request->error_Message ?? 'Please try again.'));
        }
    }
}
