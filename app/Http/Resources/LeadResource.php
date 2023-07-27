<?php

    namespace App\Http\Resources;

    use Illuminate\Http\Resources\Json\JsonResource;

    class LeadResource extends JsonResource
    {
        /**
         * Transform the resource into an array.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
         */
        //'prospecting_means' => ProspectingSourceResource::collection($this->whenLoaded('prospecting_means')),
        public function toArray($request)
        {
            return [
                    'email' => $this->email,
                    'comments' => $this->comments,
                    'last_name' => $this->last_name,
                    'first_name' => $this->first_name,
                    'account_id' => $this->account_id,
                    'prospect_id' => $this->prospect_id,
                    'attended_at' => $this->attended_at,
                    'second_last_name' => $this->second_last_name,
                    'prospecting_mean_id' => $this->prospecting_mean_id,
                    'first_assignation_at' => $this->first_assignation_at,
                    'second_assignation_at' => $this->second_assignation_at,
                    'first_assignation_user_id' => $this->first_assignation_user_id,
                    'final_assignation_user_id' => $this->final_assignation_user_id,
                    'second_assignation_user_id' => $this->second_assignation_user_id,
                    'prospecting_mean' => new ProspectingMeanResource($this->prospecting_mean)
                ];
        }
    }
