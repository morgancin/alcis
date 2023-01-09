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
            'client' => $this->client,                      //RelationShip
            'end_date' => $this->end_date,
            'end_time' => $this->end_time,
            'comments' => $this->comments,
            'start_date' => $this->start_date,
            'start_time' => $this->start_time,
            'activity_date' => $this->activity_date,
            'activity_date_format' => $this->activity_date_format,
            'activity_result' => (new ActivityResultResource($this->activity_result)),  //RelationShip
            'activity_subject' => (new ActivitySubjectResource($this->activity_subject)),  //RelationShip
        ];
    }
}
