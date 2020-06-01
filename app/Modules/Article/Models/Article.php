<?php

namespace App\Modules\Article\Models;

use App\Modules\Book\Models\Book;
use App\Modules\Author\Models\Author;
use App\Modules\Journal\Models\Journal;
use App\Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Category\Models\Category;
use App\Modules\Language\Models\Language;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{   protected $guarded = ['id'];
    protected $with=['author','categories'];

    use SoftDeletes;

  

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_articles');
    }

 

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'article_category');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'article_languages');
    }
}
