<?php

namespace App\Http\Resources;

use App\Http\Resources\Review as ReviewResource;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'type' => $this->type(),
            'content' => $this->formatContent(),
           
            'product_details' => $this->whenPivotLoaded('order_products', function () {
                return [
                    'unit' => $this->pivot->unit,
                    'type' => $this->pivot->type,
                    'price' => $this->pivot->price,
                ];
            }),
         

        ];
    }
}
