@extends('layouts.admin')

@section('title', 'Reports & Analytics - Admin Dashboard')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Reports & Analytics</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Sales Chart -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Sales Overview (Last 30 Days)</h2>
                <div class="h-64">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- Order Status Chart -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Order Status Distribution</h2>
                <div class="h-64 flex justify-center">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Top Products -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Top 5 Selling Products</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sold</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($topProducts as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $item->productVariant->product->title ?? 'N/A' }}
                                        <span class="text-xs text-gray-500 block">{{ $item->productVariant->storage ?? '' }} - {{ $item->productVariant->color ?? '' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $item->total_sold }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ₹{{ number_format($item->total_revenue, 0) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">No data available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Customer Growth -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">New Customers (Last 6 Months)</h2>
                 <div class="h-64">
                    <canvas id="customerChart"></canvas>
                </div>
            </div>

            <!-- Payment Type Chart (COD vs PayU) -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Payment Method (COD vs Online)</h2>
                 <div class="h-64 flex justify-center">
                    <canvas id="paymentTypeChart"></canvas>
                </div>
            </div>

            <!-- PayU Mode Chart -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">PayU Payment Modes</h2>
                 <div class="h-64 flex justify-center">
                    <canvas id="payuModeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent PayU Transactions -->
        <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent PayU Transactions</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($payuTransactions as $payment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->paid_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <a href="{{ route('admin.orders.show', $payment->order_id) }}" class="text-blue-600 hover:text-blue-900">
                                        {{ $payment->transaction_id }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $payment->order->user->name ?? 'Guest' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    ₹{{ number_format($payment->amount, 0) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ isset($payment->payment_details['mode']) ? strtoupper($payment->payment_details['mode']) : 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    @if($payment->payment_details)
                                        <div class="text-xs">
                                            @if(isset($payment->payment_details['card_type']))
                                                <div class="font-medium text-gray-900">{{ ucfirst($payment->payment_details['card_type']) }}</div>
                                            @endif
                                            @if(isset($payment->payment_details['issuing_bank']))
                                                <div>{{ $payment->payment_details['issuing_bank'] }}</div>
                                            @endif
                                            @if(isset($payment->payment_details['upi_va']))
                                                <div>{{ $payment->payment_details['upi_va'] }}</div>
                                            @endif
                                            @if(!isset($payment->payment_details['card_type']) && !isset($payment->payment_details['upi_va']) && isset($payment->payment_details['bankcode']))
                                                <div>Bank: {{ $payment->payment_details['bankcode'] }}</div>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No PayU transactions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesData = @json($salesData);
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: salesData.map(d => d.date),
            datasets: [{
                label: 'Revenue (₹)',
                data: salesData.map(d => d.revenue),
                borderColor: '#4F46E5',
                tension: 0.1,
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusData = @json($orderStatusDist);
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: statusData.map(d => d.status.charAt(0).toUpperCase() + d.status.slice(1)),
            datasets: [{
                data: statusData.map(d => d.total),
                backgroundColor: [
                    '#FCD34D', // Pending - Yellow
                    '#60A5FA', // Processing - Blue
                    '#A78BFA', // Shipped - Purple
                    '#34D399', // Delivered - Green
                    '#F87171'  // Cancelled - Red
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

     // Customer Chart
    const customerCtx = document.getElementById('customerChart').getContext('2d');
    const customerData = @json($customerGrowth);
    new Chart(customerCtx, {
        type: 'bar',
        data: {
            labels: customerData.map(d => d.month),
            datasets: [{
                label: 'New Customers',
                data: customerData.map(d => d.new_customers),
                backgroundColor: '#10B981',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });

    // Payment Type Chart (COD vs Online)
    const typeCtx = document.getElementById('paymentTypeChart').getContext('2d');
    const typeData = @json($paymentTypeStats);
    new Chart(typeCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(typeData),
            datasets: [{
                data: Object.values(typeData),
                backgroundColor: [
                    '#10B981', // Green (COD)
                    '#3B82F6', // Blue (PayU)
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // PayU Mode Chart
    const modeCtx = document.getElementById('payuModeChart').getContext('2d');
    const modeData = @json($payuModeStats);
    new Chart(modeCtx, {
        type: 'pie',
        data: {
            labels: Object.keys(modeData),
            datasets: [{
                data: Object.values(modeData),
                backgroundColor: [
                    '#F59E0B', // Amber
                    '#EF4444', // Red
                    '#8B5CF6', // Violet
                    '#EC4899', // Pink
                    '#6366F1', // Indigo
                    '#14B8A6', // Teal
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endsection
