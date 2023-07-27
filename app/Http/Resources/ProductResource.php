<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $aPriceLists = array();
        foreach($this->price_lists as $price_lists)
        {
            $aPriceLists[] = array(
                "name" => $price_lists->name,
                "price" => $price_lists->pivot->price,
                "product_id" => $price_lists->pivot->product_id,
                "currency_id" => $price_lists->pivot->currency_id,
                "price_list_id" => $price_lists->pivot->price_list_id
            );
        }

        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
            'quantity' => $this->quantity,
            'account_id' => $this->account_id,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'price_lists' => $aPriceLists,
            'category' => (new CategoryResource($this->category)),
            'images' => ProductImageResource::collection($this->whenLoaded('images')),
            'components' => ProductComponentResource::collection($this->whenLoaded('components')),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'active' => ($this->active) ? true : false,
            'created_user_id' => $this->created_user_id,
            'updated_user_id' => $this->updated_user_id
        ];
    }
}
