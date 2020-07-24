<?php

namespace App\Modules\Book\Models;

use App\Modules\Author\Models\Author;
use App\Modules\Article\Models\Article;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Category\Models\Category;

use App\Modules\Language\Models\Language;
use App\Modules\Collection\Models\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    protected $guarded = ['id'];
   

    use SoftDeletes;

 
    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');

    }

  

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_category');

    }
    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'book_collection');

    }

   



}
