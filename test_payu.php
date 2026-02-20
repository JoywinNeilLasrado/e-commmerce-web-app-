<?php
$key = config('services.payu.key');
$salt = config('services.payu.salt');
$cmd = 'cancel_refund_transaction';
$var1 = '403993715536829619'; // The mihpayid from the logs
$var2 = 'ref_test_001';
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

echo "TRYING mihpayid (var1)\n";
$ch = curl_init('https://test.payu.in/merchant/postservice');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
echo curl_exec($ch);
echo "\n\n";

// Let's also try where var1 is txnid
$var1_txnid = 'ORD-67B715C9C9848'; // Some random order number from earlier logs? No, let's find the correct txnid if possible.
// Actually, let's just use the mihpayid and try omitting var2 and var3
$hashSequence2 = "{$key}|{$cmd}|{$var1}|{$salt}";
$hash2 = strtolower(hash('sha512', $hashSequence2));

$postData2 = [
    'key' => $key,
    'command' => $cmd,
    'hash' => $hash2,
    'var1' => $var1,
];

echo "TRYING only var1 (mihpayid)\n";
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData2));
echo curl_exec($ch);
echo "\n\n";
