<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->email,
            'user_id' => $this->user_id,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'active' => ($this->active) ? true : false,
            'updated_user_id' => $this->updated_user_id
        ];
    }

    //https://laravel.com/docs/10.x/eloquent-resources#generating-resource-collections
    /*
    public function with(Request $request): array
    //public function withResponse()
    {
        return [
            'meta' => [
                'key' => 'value',
            ],
        ];
    }
    */
}
