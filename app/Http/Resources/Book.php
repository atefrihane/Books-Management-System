<?php

namespace App\Http\Resources;

use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\Author as AuthorResource;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\Language as LanguageResource;
use App\Http\Resources\Review as ReviewResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Book extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'editor' => $this->editor,
            'count_pages' => $this->count_pages,
            'isbn' => $this->isbn,
            'height' => $this->height,
            'width' => $this->width,
            'thickness' => $this->thickness,
            'weight' => $this->weight,
            'published_year' => $this->published_year,
            'photo' => $this->photo,
            'digital_price' => $this->digital_price,
            'paper_price' => $this->paper_price,
            'product_id' => $this->product->id,
            'articles' => ArticleResource::collection($this->articles),
            'authors' => AuthorResource::collection($this->authors),
            'categories' => CategoryResource::collection($this->categories),
            'languages' => LanguageResource::collection($this->languages),
            'aggregate' => $this->product->avgRating() ?  $this->product->avgRating()->aggregate  :  NULL ,
            'reviews' => ReviewResource::collection($this->product->activeReviews()),

        ];
    }
}
