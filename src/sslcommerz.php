<?php
return [
    'store_id' => env('STORE_ID', ''),
    'store_password' => env('STORE_PASSWORD', ''),
    'currency' => env('CURRENCY', 'BDT'),
    'success_url' => env('SUCCESS_URL', 'http://example.com/success.php'),
    'fail_url' => env('FAIL_URL', 'http://example.com/fail.php'),
    'cancel_url' => env('CANCEL_URL', 'http://example.com/cancel.php'),
    'ipn_url' => env('IPN_URL', 'http://example.com/ipn.php'),
    'sandbox_mode' => env('SANDBOX_MODE', true)
];
