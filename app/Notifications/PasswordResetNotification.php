<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification
{
    use Queueable;

    public $token, $user;
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $url = config('app.front_end') . '/change_password?token=' . $this->token.'&email='.$this->user['email'];
        return (new MailMessage)
            ->subject('Changement du mot de passe')
            ->greeting('Chèr(e)' . ' ' . ucfirst($this->user['first_name']) . ' ' . ucfirst($this->user['last_name']))
            ->line('Veuillez cliquer ci dessous pour changer votre mot de passe.')
            ->salutation('Merci pour votre confiance')
            ->action(
                'Confirmation',
                url($url)
            );
    }

}
