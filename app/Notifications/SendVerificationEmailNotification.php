<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendVerificationEmailNotification extends Notification
{
    use Queueable;

    protected $verificationUrl;
    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($verificationUrl, $message)
    {
        $this->verificationUrl = $verificationUrl;
        $this->message = $message;
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
            ->subject('Account Verification Notification')
            ->markdown('email', ['slot' => $this->message, 'verificationUrl' => $this->verificationUrl]);
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
