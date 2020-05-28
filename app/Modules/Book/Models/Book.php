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
    public $with = ['product', 'author', 'articles', 'categories', 'languages'];

    use SoftDeletes;

 
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');

    }

  

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category');

    }

   



}
