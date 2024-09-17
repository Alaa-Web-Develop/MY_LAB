<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DoctorStatusChanged extends Notification
{
    use Queueable;
    protected $doctor;


    public function __construct($doctor)
    {
        $this->doctor=$doctor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('MyLabs App')
        ->view('themes.default', [
            'doctorName'=>$this->doctor->name,
            'email'=>$this->doctor->email,
            'password'=>$this->doctor->random_number,
            'Approval_status'=>$this->doctor->Approval_Status
        ]);

     
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
