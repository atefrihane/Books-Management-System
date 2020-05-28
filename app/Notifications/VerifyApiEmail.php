<?php
namespace App\Notifications;

use App\Modules\User\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class VerifyApiEmail extends VerifyEmailBase
{
    protected $user;

    public function __construct(array $user)
    {
        $this->user = $user;
    }

    // change as you want
    public function toMail($notifiable)
    {

        return (new MailMessage)
            ->subject('Vérification du compte')
            ->greeting('Chèr(e)' . ' ' . ucfirst($this->user['first_name']) . ' ' . ucfirst($this->user['last_name']))
            ->line('Veuillez cliquer ci dessous pour confirmer votre email.')
            ->salutation('Merci pour votre confiance')
            ->action(
                'Confirmation',
                $this->verificationUrl($notifiable)
            );

    }

/**
 * Get the verification URL for the given notifiable.
 *
 * @param mixed $notifiable
 * @return string
 */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verificationapi.verify', Carbon::now()->addMinutes(60), ['id' => $notifiable->getKey()]
        ); // this will basically mimic the email endpoint with get request
    }
}
