<?php

namespace App\Modules\Order\Models;

use App\Modules\Product\Models\Product;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $guarded = ['id'];
    protected $with = ['products.content', 'user'];
    protected $appends = ['sumOrder'];
    use SoftDeletes;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')->withPivot('unit','type','price')->withTimestamps();
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getsumOrderAttribute()
    {
        $sum = DB::table('order_products')
            ->where('order_id', $this->id)
            ->select(DB::raw('sum(price * unit) as sum'))
            ->first();

        return $sum;
    }

}
