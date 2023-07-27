<?php
//https://sam-ngu.medium.com/avoiding-infinite-nested-relationship-loop-in-laravel-api-resource-35685898b360

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PipelineStageResource extends JsonResource
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
            'percentage' => $this->percentage,
            'sort_order' => $this->sort_order,
            'pipeline_id' => $this->pipeline_id,
            'pipeline' => new PipelineResource($this->whenLoaded('pipeline')),

            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_user_id' => $this->created_user_id,
            'updated_user_id' => $this->updated_user_id
        ];
    }
}
