<?php

namespace App\Http\Resources;

use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\User as UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Review extends JsonResource
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
            'rating' => $this->rating,
            'comment' => $this->comment,
            'created_at' => $this->created_at,
            'user' => (new UserResource($this->user)),
            'type'=>$this->product->type(),
            'type_id'=>$this->product->content_id
      
        ];
    }
}
