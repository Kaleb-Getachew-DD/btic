<?php

namespace App\Notifications;

use App\Models\PasswordResetRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminPasswordResetRequestMail extends Notification
{
    use Queueable;

    public function __construct(public PasswordResetRequest $request)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Password Reset Request')
            ->greeting('Hello Admin,')
            ->line('A user requested a password reset.')
            ->line('Requested email: ' . $this->request->email)
            ->action('Open Reset Requests', route('admin.password-resets.index'))
            ->line('If you did not expect this message, you can ignore it.');
    }
}

