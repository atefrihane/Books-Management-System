<?php

namespace App\Modules\Category\Models;

use App\Modules\Book\Models\Book;
use App\Modules\Article\Models\Article;
use App\Modules\Journal\Models\Journal;
use App\Modules\Release\Models\Release;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $guarded = ['id'];
    use SoftDeletes;

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_categories');
    }




    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_categories');
    }

    public function releases()
    {
        return $this->belongsToMany(Release::class, 'release_categories');
    }

  
}
