<?php

namespace App\Http\Resources;

use App\Http\Resources\Article as ArticleResource;
use App\Http\Resources\Author as AuthorResource;
use App\Http\Resources\Category as CategoryResource;
use App\Http\Resources\Journal as JournalResource;
use App\Http\Resources\Language as LanguageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Release extends JsonResource
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
            'published_year' => $this->published_year,
            'photo' => $this->photo,
            'digital_price' => $this->digital_price,
            'paper_price' => $this->paper_price,
            'journal_id' => $this->journal_id,
            'articles' => ArticleResource::collection($this->articles),
            'authors' => AuthorResource::collection($this->authors),
            'categories' => CategoryResource::collection($this->categories),
            'languages' => LanguageResource::collection($this->languages),

        ];
    }
}
