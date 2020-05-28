<?php

namespace App\Modules\Product\Models;

use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\Book as BookResource;
use App\Http\Resources\Journal as JournalResource;
use App\Modules\Article\Models\Article;
use App\Modules\Book\Models\Book;
use App\Modules\Journal\Models\Journal;
use App\Modules\Order\Models\Order;
use App\Modules\Review\Models\Review;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $guarded = ['id', 'reviews'];

    use SoftDeletes;

    public function content()
    {
        return $this->morphTo();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_products')->withTimestamps();
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')->withPivot('unit', 'type', 'price')->withTimestamps();
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function activeReviews()
    {
        return $this->reviews()->where('active', 1)->get();
    }

    public function formatContent()
    {

        switch ($this->content_type) {
            case Book::class:

                return new BookResource($this->content);
                break;
            case Article::class:
                return new ArticleResource($this->content);
                break;

            case Journal::class:
                return new JournalResource($this->content);
                break;
        }
    }

    public function type()
    {

        switch ($this->content_type) {
            case Book::class:

                return 'book';
                break;
            case Article::class:
                return 'article';
                break;

            case Journal::class:
                return 'journal';
                break;
        }

    }

    public function avgRating()
    {
        return $this->reviews()
            ->selectRaw('avg(rating) as aggregate, product_id')
            ->where('active',1)
            ->groupBy('product_id')
            ->first();

    }

}
