<?php
//https://www.youtube.com/watch?v=mZSfkIUhmXA

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProspectingMeanResource extends JsonResource
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
            'account_id' => $this->account_id,
            'prospecting_source_id' => $this->prospecting_source_id,
            'prospecting_source' => new ProspectingSourceResource($this->prospecting_source),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'active' => ($this->active) ? true : false,
            'created_user_id' => $this->created_user_id,
            'updated_user_id' => $this->updated_user_id
        ];
    }
}
