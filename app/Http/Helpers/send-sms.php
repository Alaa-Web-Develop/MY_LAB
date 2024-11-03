<?php
// Include the autoload file from Composer
require __DIR__ . '/../../vendor/autoload.php';

use Twilio\Rest\Client;

// Twilio Account SID and Auth Token
$sid    = config('services.twilio.account_sid');  // Replace with your Twilio Account SID
$token  = config('services.twilio.token');   // Replace with your Twilio Auth Token
$twilio = new Client($sid, $token);

// Recipient phone number in E.164 format
$to = "+201006664023";  // Replace with the recipient's phone number in E.164 format

// Your Twilio number (the 'From' number)
$from = config('services.twilio.from');  // Replace with your purchased Twilio number

// Message body
$body = "Hello, this is a test message from Twilio!";

// Send the SMS
try {
    $message = $twilio->messages->create($to, [
        "body" => $body,
        "from" => $from,
    ]);
    echo "Message sent successfully! Message SID: " . $message->sid;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}