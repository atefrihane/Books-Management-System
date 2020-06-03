<?php

namespace App\Modules\Category\Models;

use App\Modules\Article\Models\Article;
use App\Modules\Book\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

    protected $softCascade = ['books','articles'];

    protected $guarded = ['id'];
    use SoftDeletes;

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_category');
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_category');
    }

}
