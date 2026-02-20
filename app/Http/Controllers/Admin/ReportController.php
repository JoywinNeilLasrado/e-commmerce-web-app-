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

        // 6. Payment Type Distribution (COD vs PayU)
        $paymentTypeStats = \App\Models\Payment::where('status', 'completed')
            ->select('payment_method', DB::raw('count(*) as total'))
            ->groupBy('payment_method')
            ->pluck('total', 'payment_method')
            ->mapWithKeys(function($value, $key) {
                return [($key === 'cod' ? 'Cash on Delivery' : 'PayU Online') => $value];
            });

        // 7. PayU Mode Distribution
        $payuModeStats = \App\Models\Payment::where('payment_method', 'payu')
            ->where('status', 'completed') 
            ->get()
            ->groupBy(function($payment) {
                if (isset($payment->payment_details['mode'])) {
                    $mode = strtoupper($payment->payment_details['mode']);
                     return match($mode) {
                        'CC' => 'Credit Card',
                        'DC' => 'Debit Card',
                        'NB' => 'Net Banking',
                        'UPI' => 'UPI',
                        'WALLET' => 'Wallet',
                        default => $mode
                    };
                }
                return 'Unknown/Other';
            })
            ->map(function($group) {
                return $group->count();
            });

        // Helper to extract and normalize card network (Ultra-Greedy version)
        $normalizeCardType = function($payment) {
            $details = $payment->payment_details;
            if (empty($details)) return 'Unknown';
            
            // Search every single value in the details array for brand keywords
            $allValues = strtoupper(implode(' ', array_filter(array_values($details))));
            
            if (str_contains($allValues, 'VISA')) return 'VISA';
            if (str_contains($allValues, 'MAST') || str_contains($allValues, 'MASTER')) return 'MASTERCARD';
            if (str_contains($allValues, 'RUPAY')) return 'RUPAY';
            if (str_contains($allValues, 'AMEX') || str_contains($allValues, 'AMERICAN')) return 'AMEX';
            if (str_contains($allValues, 'DINER')) return 'DINERS';
            if (str_contains($allValues, 'MAES')) return 'MAESTRO';

            // BIN Detection backup
            foreach($details as $k => $v) {
                if (is_string($v) && preg_match('/^[0-9]{6,16}/', $v)) {
                    if (str_starts_with($v, '4')) return 'VISA';
                    if (preg_match('/^5[1-5]/', $v)) return 'MASTERCARD';
                }
            }

            // Fallback: use first non-empty specific field
            $rawBrand = collect([
                $details['network_type'] ?? null,
                $details['card_type'] ?? null,
                $details['bankcode'] ?? null,
                $details['pg_type'] ?? null,
            ])->first(fn($val) => !empty($val)) ?? 'Unknown Card Type';
            
            return $rawBrand;
        };

        // 8a. Credit Card Network Distribution
        $creditCardStats = \App\Models\Payment::where('payment_method', 'payu')
            ->where('status', 'completed')
            ->get()
            ->filter(fn($p) => strtoupper($p->payment_details['mode'] ?? '') === 'CC')
            ->groupBy($normalizeCardType)
            ->map(fn($g) => $g->count())
            ->sortDesc();

        // 8b. Debit Card Network Distribution
        $debitCardStats = \App\Models\Payment::where('payment_method', 'payu')
            ->where('status', 'completed')
            ->get()
            ->filter(fn($p) => strtoupper($p->payment_details['mode'] ?? '') === 'DC')
            ->groupBy($normalizeCardType)
            ->map(fn($g) => $g->count())
            ->sortDesc();

        // 9. Top Issuing Banks
        $bankStats = \App\Models\Payment::where('payment_method', 'payu')
            ->get()
            ->groupBy(function($payment) {
                 if (isset($payment->payment_details['issuing_bank']) && !empty($payment->payment_details['issuing_bank'])) {
                     return $payment->payment_details['issuing_bank'];
                 }
                 if (isset($payment->payment_details['bankcode']) && !empty($payment->payment_details['bankcode'])) {
                     return $payment->payment_details['bankcode']; // Fallback to bank code
                 }
                 return 'Other / Not Provided';
            })
            ->map(function($group) { return $group->count(); })
            ->sortDesc()
            ->take(5);

        // 10. AOV by Payment Mode (PayU Only)
        $aovStats = \App\Models\Payment::where('payment_method', 'payu')
            ->whereIn('status', ['completed', 'paid'])
            ->get()
            ->filter(function ($payment) {
                // Filter out if mode is missing or just 'PayU' to show only specific modes
                return isset($payment->payment_details['mode']) 
                    && !empty($payment->payment_details['mode']) 
                    && strtolower($payment->payment_details['mode']) !== 'payu';
            })
            ->groupBy(function($payment) {
                return $payment->payment_details['mode'];
            })
            ->map(function($group) {
                return round($group->avg('amount'), 0);
            });

        // 12. AOV Comparison (COD vs PayU)
        $aovComparisonStats = \App\Models\Payment::whereIn('status', ['completed', 'paid'])
            ->get()
            ->groupBy(function($payment) {
                return $payment->payment_method === 'cod' ? 'COD' : 'PayU (Online)';
            })
            ->map(function($group) {
                return round($group->avg('amount'), 0);
            });

        // 11. Success vs Failure Rate
        $successRateStats = \App\Models\Payment::where('payment_method', 'payu')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // 5. Recent PayU Transactions
        $payuTransactions = \App\Models\Payment::where('payment_method', 'payu')
            ->with(['order.user'])
            ->latest() // Use created_at instead of paid_at to avoid null error on pending
            ->take(10)
            ->get();        

        return view('admin.reports.index', compact(
            'salesData', 
            'topProducts', 
            'orderStatusDist', 
            'customerGrowth',
            'payuTransactions',
            'paymentTypeStats',
            'payuModeStats',
            'creditCardStats',
            'debitCardStats',
            'bankStats',
            'aovStats',
            'aovComparisonStats',
            'successRateStats'
        ));
    }
}
