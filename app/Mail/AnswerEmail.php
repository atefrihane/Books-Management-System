<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Modules\User\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AnswerEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user, $message;
    public function __construct(User $user,$message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->markdown('emails.answerSupport')
            ->subject('Réponse à votre demande')
            ->with([
                'user' => $this->user,
                'message' => $this->message,

            ]);
    }
}
