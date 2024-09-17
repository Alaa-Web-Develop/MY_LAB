<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PointsTransferStatus extends Notification
{
    use Queueable;

    protected $doctor;
protected $transferRequest;

    public function __construct($doctor,$transferRequest)
    {
            $this->doctor = $doctor;
    $this->transferRequest = $transferRequest;

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
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('Your Points Transfer Request Status')
        ->view('themes.pointsTransfer', [
            'doctorName' => $this->doctor->name,
                    'points' => $this->transferRequest->points,
                    'status' => ucfirst($this->transferRequest->status),
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
