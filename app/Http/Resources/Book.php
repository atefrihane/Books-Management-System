<?php

namespace App\Http\Resources;

use App\Http\Resources\Author as AuthorResource;
use App\Http\Resources\Category as CategoryResource;
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
            'subject' => $this->subject,
            'why_to_read' => $this->why_to_read,
            'quotes' => $this->quotes,
            'active' => $this->active,
            'photo' => $this->photo,
            'audio_link' => $this->audio_link,
            'pdf_link' => $this->pdf_link,
            'views' => $this->views,
            'author' => new AuthorResource($this->author),
            'categories' => CategoryResource::collection($this->categories),

        ];
    }
}
