<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Payment;
use App\Services\PayUService;

class CheckRefundStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payu:check-refunds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Polls PayU to check the status of queued refunds and updates the local database.';

    /**
     * Execute the console command.
     */
    public function handle(PayUService $payUService)
    {
        $this->info("Checking for queued refunds...");

        // Get all completed payments that are stuck in refund_queued
        $payments = Payment::where('status', 'refund_queued')->where('payment_method', 'payu')->get();
        
        if ($payments->isEmpty()) {
            $this->info("No queued refunds found.");
            return;
        }

        $this->info("Found {$payments->count()} queued refunds. Checking status...");

        foreach ($payments as $payment) {
            $details = $payment->payment_details;
            $requestId = $details['refund_request_id'] ?? null;

            if (!$requestId) {
                $this->error("Payment ID {$payment->id} (Order #{$payment->order_id}) is missing a refund_request_id.");
                continue;
            }

            $result = $payUService->checkRefundStatus($requestId);

            if ($result['status']) {
                $statusStr = $result['refund_status']; // 'success', 'pending', or 'failed'

                if ($statusStr === 'success') {
                    $payment->update(['status' => 'refunded']);
                    $payment->order->update(['payment_status' => 'refunded']);
                    $this->info("Payment ID {$payment->id} successfully refunded.");
                } else if ($statusStr === 'failed') {
                    // It failed during queuing. We should probably mark it failed, but since 
                    // the order is already 'cancelled', the payment just goes back to failed state.
                    $payment->update(['status' => 'failed']);
                    $this->error("Payment ID {$payment->id} refund failed at gateway.");
                } else {
                    $this->line("Payment ID {$payment->id} is still pending.");
                }
            } else {
                $this->error("Failed to check status for Payment ID {$payment->id}: " . ($result['message'] ?? 'Unknown error'));
            }
        }

        $this->info("Refund checking complete.");
    }
}
