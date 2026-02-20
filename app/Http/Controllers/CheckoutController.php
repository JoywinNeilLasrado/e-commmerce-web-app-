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
            'payment_method' => 'required|in:cod,payu',
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
            // Payment Processing

            if ($request->payment_method === 'payu') {
                $order->update(['status' => 'pending']); // Ensure status is pending
                DB::commit(); // Commit transaction before redirecting

                // PayU Configuration
                $key = config('services.payu.key');
                $salt = config('services.payu.salt');
                $txnid = $order->order_number; // Use Order Number as Transaction ID
                $amount = $order->total;
                $productinfo = 'Order #' . $order->order_number;
                $firstname = $user->name;
                $email = $user->email;
                $phone = $order->address->phone ?? '9999999999';
                $surl = route('payment.payu.response');
                $furl = route('payment.payu.response');
                
                // Hash Sequence: key|txnid|amount|productinfo|firstname|email|udf1|udf2|...|udf10|salt
                $hashSequence = "$key|$txnid|$amount|$productinfo|$firstname|$email|||||||||||$salt";
                $hash = strtolower(hash('sha512', $hashSequence));

                $payuUrl = config('services.payu.test_mode') ? 'https://test.payu.in/_payment' : 'https://secure.payu.in/_payment';

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
                    'status' => 'processing', // Auto-process COD orders
                    'payment_status' => $paymentStatus === 'completed' ? 'paid' : 'pending',
                    'paid_at' => $paymentStatus === 'completed' ? now() : null,
                ]);
            }

            // Clear Cart
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            // dd(explode('(SQL:', $e->getMessage())[0]); // Debugging
            return back()->with('error', 'Failed to place order. Please try again. ' . $e->getMessage());
        }
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
        
        // Response Hash Sequence: salt|status||||||udf5|udf4|udf3|udf2|udf1|email|firstname|productinfo|amount|txnid|key
        $retHashSeq = "$salt|$status|||||||||||$email|$firstname|$productinfo|$amount|$txnid|$key";
        $hash = strtolower(hash('sha512', $retHashSeq));
        
        $order = Order::where('order_number', $txnid)->first();
        if (!$order) {
            return redirect()->route('cart.index')->with('error', 'Order not found.');
        }

        if ($hash != $posted_hash) {
            DB::transaction(function () use ($order) {
                foreach ($order->items as $item) {
                    $item->productVariant->increment('stock', $item->quantity);
                }
                $order->update(['status' => 'cancelled']);
            });
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
                    'network_type' => $request->network_type, // Capturing specific network type as identified by user
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

            // Clear Cart (Handle potential multiple carts)
            $carts = Cart::where('user_id', $order->user_id)->get();
            foreach ($carts as $c) {
                $c->items()->delete();
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
                    $item->productVariant->increment('stock', $item->quantity);
                }
                $order->update(['status' => 'cancelled']);
            });
            
            return redirect()->route('checkout.index')->with('error', 'Payment failed: ' . ($request->error_Message ?? 'Please try again.'));
        }
    }
}
