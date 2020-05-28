<?php

namespace App\Modules\Support\Models;

use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Support extends Model
{
    protected $guarded = ['id'];
    protected $with = ['user'];
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
