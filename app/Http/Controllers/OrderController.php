<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\PayUService;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $orders = Auth::user()->orders()->with(['items.product', 'payment'])->latest()->paginate(10);
        
        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'orders' => $orders
            ]);
        }

        return view('orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            if ($request->routeIs('api.*') || $request->wantsJson()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            abort(403);
        }

        $order->load(['items.product.reviews', 'items.product.condition', 'payment', 'address']);

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'order' => $order
            ]);
        }

        return view('orders.show', compact('order'));
    }

    public function cancel(Request $request, Order $order, PayUService $payUService)
    {
        if ($order->user_id !== Auth::id()) {
            if ($request->routeIs('api.*') || $request->wantsJson()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            abort(403);
        }

        // Only allow cancellation if order is pending or processing
        if (!in_array($order->status, ['pending', 'processing'])) {
            if ($request->routeIs('api.*') || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This order cannot be cancelled as it is already ' . $order->status . '.'
                ], 400);
            }
            return back()->with('error', 'This order cannot be cancelled as it is already ' . $order->status . '.');
        }

        try {
            DB::beginTransaction();

            $refundStatus = true;
            $refundMessage = 'Your order has been cancelled successfully.';

            // Process refund if payment was online and complete
            if ($order->payment_status === 'paid') {
                $payment = $order->payments()->where('status', 'completed')->where('payment_method', 'payu')->latest()->first();
                if ($payment) {
                    $mihpayid = $payment->payment_details['mihpayid'] ?? $payment->transaction_id;
                    $refundResult = $payUService->refund($mihpayid, (float) $order->total);
                    
                    if ($refundResult['status']) {
                        $isQueued = stripos($refundResult['message'], 'Queued') !== false;
                        $statusToSet = $isQueued ? 'refund_queued' : 'refunded';
                        $paymentDetails = $payment->payment_details ?? [];
                        if (isset($refundResult['data']['request_id'])) {
                            $paymentDetails['refund_request_id'] = $refundResult['data']['request_id'];
                        }
                        $payment->update([
                            'status' => $statusToSet,
                            'payment_details' => $paymentDetails
                        ]);
                        $order->update(['payment_status' => $statusToSet]);

                        $refundMsgText = $isQueued ? 'Refund Request Queued by Payment Gateway.' : 'Refund initiated successfully.';
                        $refundMessage = 'Your order has been cancelled. ' . $refundMsgText;
                    } else {
                        $refundStatus = false;
                        $refundMessage = 'Order cancellation failed. Refund could not be processed: ' . $refundResult['message'];
                    }
                }
            }

            if (!$refundStatus) {
                DB::rollBack();
                if ($request->routeIs('api.*') || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $refundMessage
                    ], 400);
                }
                return back()->with('error', $refundMessage);
            }

            // Restore Stock
            foreach ($order->items as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            $order->update(['status' => 'cancelled']);

            DB::commit();

            if ($request->routeIs('api.*') || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $refundMessage,
                    'order' => $order
                ]);
            }

            return redirect()->route('orders.show', $order)->with('success', $refundMessage);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Cancellation Error: ' . $e->getMessage());
            
            if ($request->routeIs('api.*') || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while cancelling your order. Please try again.'
                ], 500);
            }
            return back()->with('error', 'An error occurred while cancelling your order. Please try again.');
        }
    }
}
