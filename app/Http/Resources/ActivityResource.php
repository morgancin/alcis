<?php
//https://www.youtube.com/watch?v=mZSfkIUhmXA

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'comments' => $this->comments,
            'user_id' => $this->created_user_id,
            'prospect' => (new ProspectResource($this->prospect)),
            'activity_result' => (new ActivityResultResource($this->activity_result)),
            'activity_subject' => (new ActivitySubjectResource($this->activity_subject)),
            'end_date' => ($this->end_date) ? $this->end_date->format('Y-m-d') : null,
            'start_date' => ($this->start_date) ? $this->start_date->format('H:i') : null,
            'activity_date' => ($this->activity_date) ? $this->activity_date->format('d/m/Y H:i') : null,

            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_user_id' => $this->created_user_id,
            'updated_user_id' => $this->updated_user_id
        ];
    }
}
