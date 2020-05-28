<?php

namespace App\Modules\Language\Models;

use App\Modules\Book\Models\Book;
use App\Modules\Article\Models\Article;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    protected $guarded = ['id'];
    use SoftDeletes;

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_languages');
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class, 'journal_languages');
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_languages');
    }

}
