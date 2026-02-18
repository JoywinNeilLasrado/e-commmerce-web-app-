<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Auth::user()->orders()->with(['items.productVariant.product', 'payment'])->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['items.productVariant.product', 'items.productVariant.condition', 'payment', 'address']);

        return view('orders.show', compact('order'));
    }
}
