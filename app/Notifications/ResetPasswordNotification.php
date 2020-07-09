<?php

namespace App\Notifications;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPasswordNotification extends Notification implements ShouldQueue
{
    use Queueable;

    const DEFAULT_ROUTE = 'password.reset';

    /** @var string */
    public $token;

    /** @var string|null */
    public $route;

    /**
     * @param string $token
     * @param string|null $route
     */
    public function __construct($token, $route = null)
    {
        $this->token = $token;
        $this->route = $route;
    }

    /**
     * @param mixed $notifiable
     * @return string[]|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * @param string $route
     * @return ResetPasswordNotification
     */
    public function withRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        $route = $this->route ?? static::DEFAULT_ROUTE;

        return (new MailMessage)
            ->subject(Lang::get('Reset Password Notification'))
            ->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
            ->action(Lang::get('Reset Password'), route($route, ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()]))
            ->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
            ->line(Lang::get('If you did not request a password reset, no further action is required.'));
    }
}
