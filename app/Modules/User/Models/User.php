<?php

namespace App\Modules\User\Models;

use App\Jobs\VerifyEmail;
use App\Jobs\ResetPassword;
use App\Modules\Role\Models\Role;
use Laravel\Passport\HasApiTokens;
use App\Modules\Order\Models\Order;
use App\Modules\Review\Models\Review;
use App\Modules\Product\Models\Product;
use App\Modules\Support\Models\Support;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes, HasApiTokens;
    protected $with = ['role'];
    protected $guarded = ['id'];

    public function formatName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function isAdmin()
    {
        return $this->role->name != 'user';
    }



  

    
    public function sendApiEmailVerificationNotification()
    {
        VerifyEmail::dispatch($this);

    }

    public function sendPasswordResetNotification($token)
    {

        ResetPassword::dispatch($this, $token);

    }

   
}
