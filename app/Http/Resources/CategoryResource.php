<?php
//https://www.youtube.com/watch?v=mZSfkIUhmXA

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'category_id' => $this->category_id,
            'products_count'=> $this->whenLoaded('products', function() {
                return $this->products->count();
            }),
            'subcategories' => CategoryResource::collection($this->whenLoaded('subcategories')),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'active' => ($this->active) ? true : false,
            'created_user_id' => $this->created_user_id,
            'updated_user_id' => $this->updated_user_id
        ];
    }
}
