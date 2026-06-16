<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomHtmlNotification extends Notification
{
    public function __construct(
        public string $subject,
        public string $htmlContent,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->view('notifications.custom-html', [
                'htmlContent' => $this->htmlContent,
            ]);
    }
}
