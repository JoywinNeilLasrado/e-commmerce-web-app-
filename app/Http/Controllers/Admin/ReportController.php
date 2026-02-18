<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Sales Overview (Last 30 Days)
        $salesData = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total) as revenue'),
            DB::raw('COUNT(*) as orders')
        )
        ->where('created_at', '>=', Carbon::now()->subDays(30))
        ->where('status', '!=', 'cancelled')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        // 2. Top Selling Products
        $topProducts = OrderItem::select(
            'product_variant_id',
            DB::raw('SUM(quantity) as total_sold'),
            DB::raw('SUM(price * quantity) as total_revenue')
        )
        ->with(['productVariant.product', 'productVariant.condition'])
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->where('orders.status', '!=', 'cancelled')
        ->groupBy('product_variant_id')
        ->orderByDesc('total_sold')
        ->take(5)
        ->get();

        // 3. Order Status Distribution
        $orderStatusDist = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // 4. Customer Growth (Last 6 Months)
        $monthExpression = DB::getDriverName() === 'sqlite' 
            ? 'strftime("%Y-%m", created_at)' 
            : 'DATE_FORMAT(created_at, "%Y-%m")';

        $customerGrowth = User::role('customer')
            ->select(
                DB::raw("$monthExpression as month"),
                DB::raw('COUNT(*) as new_customers')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.reports.index', compact(
            'salesData', 
            'topProducts', 
            'orderStatusDist', 
            'customerGrowth'
        ));
    }
}
