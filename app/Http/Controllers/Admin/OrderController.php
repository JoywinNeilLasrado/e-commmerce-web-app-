<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user', 'items')
            ->latest()
            ->paginate(15);
            
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'address', 'payment']);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $updateData = ['status' => $validated['status']];

        // Automatic timestamps based on status
        if ($validated['status'] === 'shipped' && !$order->shipped_at) {
            $updateData['shipped_at'] = now();
        } elseif ($validated['status'] === 'delivered' && !$order->delivered_at) {
            $updateData['delivered_at'] = now();
        }

        $order->update($updateData);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order status updated successfully.');
    }

    public function markPaymentReceived(Order $order)
    {
        // 1. Update Payment record
        $payment = $order->payment;
        if ($payment) {
            $payment->update([
                'status' => 'completed',
                'paid_at' => now(),
            ]);
        }

        // 2. Update Order record
        $order->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Payment marked as received successfully!');
    }


}
