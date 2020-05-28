<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Modules\User\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivationEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public  $user;
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
     
        return $this->markdown('emails.welcome')
        ->subject('Activation du compte')
            ->with([
                'user' => $this->user,
       
            ]);
    }
}
