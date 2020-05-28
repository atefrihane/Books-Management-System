<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'email' => $this->email,
            'role' => ucfirst($this->role->name),
            'first_name' => $this->first_name ? $this->first_name :  '',
            'last_name' => $this->last_name ? $this->last_name :  '',
            'occupation' => $this->occupation ? $this->occupation :  '',
            'institution' => $this->institution ? $this->institution :  '',
            'country' => $this->country ? $this->country :  '',
            'city' => $this->city ? $this->city :  '',
            'zipcode' => $this->zipcode ? $this->zipcode :  '',
            'address' => $this->address ? $this->address :  '',
            'phone' => $this->phone ? $this->phone :  '',

        ];
    }
}
