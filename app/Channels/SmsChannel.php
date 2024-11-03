<?php

namespace App\Channels;

use Twilio\Rest\Client;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'));
    }
 
    public function send($notifiable, Notification $notification)
    {
         // Ensure the notification has a toSms method
         if (!method_exists($notification, 'toSms')) {
            return;
        }

        $message = $notification->toSms($notifiable);

        $this->twilio->messages->create(
            $message['phone_number'],
            [
                'from' => env('TWILIO_FROM'),
                'body' => $message['message'],
            ]
        );
    }
}