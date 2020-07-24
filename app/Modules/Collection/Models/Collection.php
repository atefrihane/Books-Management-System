<?php

namespace App\Modules\Collection\Models;

use App\Modules\Book\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{

    protected $guarded = ['id'];
    use SoftDeletes;
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_collection');

    }
}
