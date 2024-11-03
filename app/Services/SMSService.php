<?php
namespace App\Services;

use Log;
use Twilio\Rest\Client;

class SMSService
{
protected $twilio;

public function __construct()
{
    //details in config.services
  
    $token=config('services.twilio.token');
    $account_sid=config('services.twilio.account_sid');
    $this->twilio=new Client( $account_sid,$token);
    //client for accessing the Twilio API.
  
}
public function sendSMS($phoneNumber,$message)
{
    try {
        $this->twilio->messages->create($phoneNumber,[
            'from'=>config('services.twilio.from'),
            'body'=>$message,
                ]);
    } catch (\Throwable $th) {
        \Log::error('Twilio SMS Error: ' . $th->getMessage());
    }
   
}


}