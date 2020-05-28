<?php

namespace App\Jobs;

use App\Modules\User\Models\User;
use App\Notifications\PasswordResetNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ResetPassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user, $token;
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function handle()
    {

        $this->user->notify(new PasswordResetNotification($this->user->toArray(), $this->token));
    }
}
