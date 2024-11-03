<?php

namespace App\Notifications;

use Twilio\Rest\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SendSmsNotification extends Notification
{
  

    use Queueable;

    protected $message;
    protected $phoneNumber;


    /**
     * Create a new notification instance.
     */
    public function __construct($message, $phoneNumber)
    {
        $this->message = $message;
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['sms'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }
    public function toSms($notifiable)
    {
        return [
            'phone_number' => $this->phoneNumber,
            'message' => $this->message,
        ];

        // $sid = config('services.twilio.account_sid');
        // $token = config('services.twilio.token');
        // $from = config('services.twilio.from');

        // $twilio = new Client($sid, $token);

        // try {
        //     $twilio->messages->create(
        //         $this->phoneNumber, // The recipient's phone number
        //         [
        //             'from' => $from, // Your Twilio number
        //             'body' => $this->message, // SMS content
        //         ]
        //     );
        // } catch (\Exception $e) {
        //     \Log::error('Twilio SMS Error: ' . $e->getMessage());
        // }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
