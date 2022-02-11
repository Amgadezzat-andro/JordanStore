<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'address_id' => $this->id,
            'street_number' => $this->street_number,
            'street_name' => $this->street_name,
            'city'=> $this->city,
            'state'=> $this->state,
            'country'=> $this->country,
            'post_code'=> $this->post_code,
        ];
    }
}
