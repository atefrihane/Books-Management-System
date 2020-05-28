<?php

namespace App\Modules\Book\Models;

use App\Modules\Article\Models\Article;
use App\Modules\Author\Models\Author;
use App\Modules\Category\Models\Category;
use App\Modules\Language\Models\Language;
use App\Modules\Product\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    protected $guarded = ['id'];
    public $with = ['product', 'authors', 'articles', 'categories', 'languages'];

    use SoftDeletes;

    public function product()
    {
        return $this->morphOne(Product::class, 'content');
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_authors');

    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'book_articles');

    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_categories');

    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'book_languages');

    }



}
