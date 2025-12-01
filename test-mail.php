<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Http\Kernel');
$response = $kernel->handle($request = Illuminate\Http\Request::capture());

use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('Test mail từ LegalEase', function($message) {
        $message->to('ptuongzdri1279@gmail.com')
                ->subject('Test Mail');
    });
    echo "✅ Mail sent successfully!";
} catch (\Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
