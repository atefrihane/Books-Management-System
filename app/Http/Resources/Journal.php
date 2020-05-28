<?php

namespace App\Http\Resources;

use App\Http\Resources\Release as ReleaseResource;
use App\Http\Resources\Review as ReviewResource;
use App\Http\Resources\Author as AuthorResource;
use App\Http\Resources\Language as LanguageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Journal extends JsonResource
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
            'director' => $this->director,
            'editor' => $this->editor,
            'published_year' => $this->published_year,
            'photo' => $this->photo,
            'product_id' => $this->product->id,
            'releases' => ReleaseResource::collection($this->releases),
            'authors' => AuthorResource::collection($this->authors),
            'languages' => LanguageResource::collection($this->languages),
            'aggregate' => $this->product->avgRating() ?  $this->product->avgRating()->aggregate  :  NULL ,
            'reviews' => ReviewResource::collection($this->product->activeReviews()),

        ];
    }
}
