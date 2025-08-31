<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeletePostNotification extends Notification
{
    use Queueable;

    public function __construct() {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function viaConnections(): array
    {
        return [
            'mail' => 'database',
        ];
    }

    public function viaQueues(): array
    {
        return [
            'mail' => 'mail-queue',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $userName = $notifiable->name ?? 'User';

        return (new MailMessage)
            ->greeting("Dear {$userName},")
            ->subject('Your post has been deleted')
            ->line('Your post has been deleted')
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
