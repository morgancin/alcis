<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResultResource extends JsonResource
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
            'activity_type_id' => $this->activity_type_id,
            'pipeline_stage_id' => $this->pipeline_stage_id,
            'is_tracking' => ($this->is_tracking) ? true : false,
            'activity_type' => (new ActivityTypeResource($this->activity_type)),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'active' => ($this->active) ? true : false,
            'created_user_id' => $this->created_user_id,
            'updated_user_id' => $this->updated_user_id
        ];
    }
}
