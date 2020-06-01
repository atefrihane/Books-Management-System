<?php

namespace App\Modules\Author\Models;

use App\Modules\Book\Models\Book;
use App\Modules\Article\Models\Article;
use App\Modules\Journal\Models\Journal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    protected $guarded = ['id'];
    use SoftDeletes;
    public function fullName()
    {
        return ucfirst($this->first_name).' '.ucfirst($this->last_name);
    }
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class, 'journal_authors');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
