<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// The request_id returned in the Queued response earlier
$request_id = '139397323';
$command = 'check_action_status';
$key = config('services.payu.key');
$salt = config('services.payu.salt');
$hash = strtolower(hash('sha512', "$key|$command|$request_id|$salt"));

$postData = [
    'key' => $key,
    'command' => $command,
    'hash' => $hash,
    'var1' => $request_id,
];

$ch = curl_init('https://test.payu.in/merchant/postservice');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);
echo "Response for check_action_status with request_id\n";
print_r(unserialize($response) ?: $response);

