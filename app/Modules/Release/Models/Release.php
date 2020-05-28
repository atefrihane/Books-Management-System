<?php

namespace App\Modules\Release\Models;

use App\Modules\Article\Models\Article;
use App\Modules\Author\Models\Author;
use App\Modules\Category\Models\Category;
use App\Modules\Journal\Models\Journal;
use App\Modules\Language\Models\Language;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Release extends Model
{
    protected $guarded = ['id'];
    public $with=['authors','articles','categories','languages'];
    use SoftDeletes;

    public function journal()
    {
        return $this->belongsTo(Journal::class, 'journal_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'release_categories');
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'release_authors');

    }

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'release_articles');

    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'release_languages');

    }

}
