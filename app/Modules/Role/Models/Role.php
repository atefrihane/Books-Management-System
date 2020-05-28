<?php

namespace App\Modules\Role\Models;

use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model {

    use SoftDeletes;

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
