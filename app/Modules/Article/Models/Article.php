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
    protected $with=['product' ,'authors','categories','languages'];

    use SoftDeletes;

    public function product()
    {
        return $this->morphOne(Product::class, 'content');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_articles');
    }

 

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'article_authors');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'article_categories');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'article_languages');
    }
}
