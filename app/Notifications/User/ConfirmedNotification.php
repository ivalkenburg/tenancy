<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConfirmedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $ip;

    /**
     * @param string $ip
     */
    public function __construct($ip)
    {
        $this->ip = $ip;
    }

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
            ->subject('Account Confirmed')
            ->greeting("Hey, {$notifiable->name}")
            ->line("Your account ({$notifiable->email}) has successfully been confirmed.")
            ->line("The confirmation was made from IP address: {$this->ip}")
            ->line('If you did not initiate this confirmation, please contact your administrator immediately.');
    }
}
