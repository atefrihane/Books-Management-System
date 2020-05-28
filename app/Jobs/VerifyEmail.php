<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Modules\User\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\VerifyApiEmail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class VerifyEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        $this->user->notify(new VerifyApiEmail($this->user->toArray()));
    }
}
