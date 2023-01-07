<?php
//https://sam-ngu.medium.com/avoiding-infinite-nested-relationship-loop-in-laravel-api-resource-35685898b360

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
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
            'id' => $this->id,
            'price' => $this->price,
            'currency' => new CurrencyResource($this->currency),
            'prices_list' => new PriceListResource($this->whenLoaded('prices_list')),
        ];
    }
}
