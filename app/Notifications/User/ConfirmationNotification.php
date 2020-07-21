<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConfirmationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Account Confirmation')
            ->greeting("Hey, {$notifiable->name}")
            ->line('Click the "Confirm" button to complete the confirmation process.')
            ->action('Confirm', route('confirm.show', ['token' => $notifiable->confirmation_token, 'email' => $notifiable->email]));
    }
}
