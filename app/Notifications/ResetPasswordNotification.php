<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as BaseResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends BaseResetPassword
{
    public function toMail($notifiable)
    {
        $url = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        $expire = config('auth.passwords.'.config('auth.defaults.passwords').'.expire').' minutes';

        return (new MailMessage)
            ->subject('Reset Your Password - Villa Diana Hotel')
            ->view('emails.password-reset', [
                'url' => $url,
                'expire' => $expire,
            ]);
    }
}