<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PayUService
{
    protected string $key;
    protected string $salt;
    protected string $baseUrl;

    public function __construct()
    {
        $this->key = config('services.payu.key');
        $this->salt = config('services.payu.salt');
        $this->baseUrl = config('services.payu.test_mode') 
            ? 'https://test.payu.in/merchant/postservice' 
            : 'https://info.payu.in/merchant/postservice.php'; // production endpoint
    }

    /**
     * Initiate a refund for a transaction.
     *
     * @param string $mihpayid PayU transaction ID
     * @param float $amount Refund amount
     * @return array
     */
    public function refund(string $mihpayid, float $amount): array
    {
        if (empty($this->key) || empty($this->salt)) {
            Log::error('PayU Configuration missing.');
            return ['status' => false, 'message' => 'Payment gateway configuration missing.'];
        }

        $command = 'cancel_refund_transaction';
        $var1 = $mihpayid;
        $var2 = substr(uniqid('ref_'), 0, 23); // Token ID (optional, but good to provide)
        $var3 = number_format($amount, 2, '.', ''); // Ensure amount has 2 decimal precision

        $hashSequence = "{$this->key}|{$command}|{$var1}|{$this->salt}";
        $hash = strtolower(hash('sha512', $hashSequence));
        
        Log::info('PayU Refund Attempt details', [
            'hashSequence_no_salt' => "{$this->key}|{$command}|{$var1}",
            'var2' => $var2,
            'var3' => $var3,
        ]);

        $postData = [
            'key' => $this->key,
            'command' => $command,
            'hash' => $hash,
            'var1' => $var1,
            'var2' => $var2,
            'var3' => $var3,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignore SSL on local
        
        $responseBody = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
             Log::error('PayU Refund cURL Error', ['error' => $curlError, 'mihpayid' => $mihpayid]);
             return ['status' => false, 'message' => 'Failed to connect to payment gateway: ' . $curlError];
        }

        $data = json_decode($responseBody, true);
            
        Log::info('PayU Raw Refund Response', ['body' => $responseBody, 'mihpayid' => $mihpayid]);

        // PayU sometimes returns a serialized PHP array or a query string instead of JSON directly
        if ($data === null) {
            // Check if it's a serialized array. Some PayU environments return broken serialized strings 
            // where length descriptors are missing/truncated for the last keys.
            $unserialized = @unserialize($responseBody);
            if ($unserialized !== false || $responseBody === 'b:0;') {
                $data = $unserialized;
            } else {
                // Try parsing it as a query string first
                parse_str($responseBody, $parsedStr);
                
                // If parse_str didn't give us anything useful, try regex extraction from the broken serialized string
                if (empty($parsedStr) || !isset($parsedStr['status'])) {
                     $data = [];
                     if (preg_match('/"status";i:(\d+);/', $responseBody, $statusMatches)) {
                         $data['status'] = (int) $statusMatches[1];
                     }
                     if (preg_match('/"msg";s:\d+:"([^"]+)";/', $responseBody, $msgMatches)) {
                         $data['msg'] = $msgMatches[1];
                     }
                     if (empty($data)) {
                         $data = ['msg' => $responseBody]; // Ultimate fallback
                     }
                } else {
                     $data = $parsedStr;
                }
            }
        }

        if (isset($data['status']) && $data['status'] == 1) {
            $successMsg = $data['msg'] ?? 'Refund initiated successfully.';
            // Fix formatting if it is snake_case
            $successMsg = str_replace('_', ' ', $successMsg);
            return ['status' => true, 'message' => $successMsg, 'data' => $data];
        }

        Log::error('PayU Refund Failed', ['response' => $data, 'raw_body' => $responseBody, 'mihpayid' => $mihpayid]);
        return ['status' => false, 'message' => $data['msg'] ?? 'Refund failed via payment gateway.', 'data' => $data];
    }

    /**
     * Check the status of a queued refund using its Request ID.
     *
     * @param string $requestId
     * @return array
     */
    public function checkRefundStatus(string $requestId): array
    {
        if (empty($this->key) || empty($this->salt)) {
            Log::error('PayU Configuration missing.');
            return ['status' => false, 'message' => 'Configuration missing.'];
        }

        $command = 'check_action_status';
        $var1 = $requestId;

        $hashSequence = "{$this->key}|{$command}|{$var1}|{$this->salt}";
        $hash = strtolower(hash('sha512', $hashSequence));

        $postData = [
            'key' => $this->key,
            'command' => $command,
            'hash' => $hash,
            'var1' => $var1,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $responseBody = curl_exec($ch);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
             Log::error('PayU Check Status cURL Error', ['error' => $curlError, 'request_id' => $requestId]);
             return ['status' => false, 'message' => 'Failed to connect: ' . $curlError];
        }

        $data = @unserialize($responseBody);
        
        if ($data === false && $responseBody !== 'b:0;') {
            Log::error('PayU Check Status Parse Error', ['body' => $responseBody]);
            return ['status' => false, 'message' => 'Invalid response from PayU'];
        }

        if (isset($data['status']) && $data['status'] == 1 && isset($data['transaction_details'][$requestId][$requestId])) {
            $details = $data['transaction_details'][$requestId][$requestId];
            $refundStatus = strtolower($details['status'] ?? '');
            
            if ($refundStatus === 'success') {
                return ['status' => true, 'refund_status' => 'success', 'data' => $details];
            } else if ($refundStatus === 'pending') {
                return ['status' => true, 'refund_status' => 'pending', 'data' => $details];
            } else if ($refundStatus === 'failure' || $refundStatus === 'failed') {
                return ['status' => true, 'refund_status' => 'failed', 'data' => $details];
            }
        }

        Log::warning('PayU Check Status Unknown/Failed', ['response' => $data, 'request_id' => $requestId]);
        return ['status' => false, 'message' => 'Could not determine refund status.', 'data' => $data];
    }
}
