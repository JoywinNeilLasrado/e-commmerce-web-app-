<?php
$key = config('services.payu.key');
$salt = config('services.payu.salt');
$cmd = 'cancel_refund_transaction';
$var1 = 'ORD-67B715C9C9848'; // The txnid from the earlier order
$var2 = 'ref_test_002';
$var3 = '10.00';

$hashSequence = "{$key}|{$cmd}|{$var1}|{$salt}";
$hash = strtolower(hash('sha512', $hashSequence));

$postData = [
    'key' => $key,
    'command' => $cmd,
    'hash' => $hash,
    'var1' => $var1,
    'var2' => $var2,
    'var3' => $var3,
];

echo "TRYING txnid (var1)\n";
$ch = curl_init('https://test.payu.in/merchant/postservice');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
echo curl_exec($ch);
echo "\n\n";
