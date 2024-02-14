<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserLoggedInNotification  extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
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
        $appName = env("APP_NAME");

        $message = "\n\n\n<b>Hello " . $notifiable->lastname . "</b>,\n\n" .
            "You have logged in to your account.\n\n" .
            "If this was not you, please contact us immediately.\n\n" .
            "Regards, \n<b>" . $appName."</b>\n\n\n";

        return (new MailMessage)
            ->from('info@aprodigitals.com', $appName)
            ->markdown('email', ['slot' => $message]);

        // return (new MailMessage)
        //     ->subject(env('APP_NAME').' Notifications')
        //     ->markdown('email', ['subcopy' => 'This is a custom subcopy message.']);
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
