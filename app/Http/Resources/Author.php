<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Book as BookResource;
use App\Http\Resources\Journal as JournalResource;
use App\Http\Resources\Article as ArticleResource;
class Author extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'biography' => $this->biography,
            'photo' => $this->photo
            // 'books' => BookResource::collection($this->books),
            // 'journals' => JournalResource::collection($this->journals),
            // 'articles' => ArticleResource::collection($this->articles),

        ];
    }
}
