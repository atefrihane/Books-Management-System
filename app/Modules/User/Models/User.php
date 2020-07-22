<?php

namespace App\Modules\User\Models;

use App\Jobs\ResetPassword;
use App\Jobs\VerifyEmail;
use App\Modules\Role\Models\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, SoftDeletes, HasApiTokens;
    protected $with = ['role'];
    protected $guarded = ['id'];

    const ROLE_SUPERADMIN = 1;
    const ROLE_ADMIN = 2;
    const ROLE_USER = 3;

    public function formatName()
    {
        return ucfirst($this->full_name);
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

    public function scopeRegistered($query)
    {
        return $query->whereRoleId(3);
    }

}
