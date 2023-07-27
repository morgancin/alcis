<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProspectResource extends JsonResource
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
            'age' => $this->age,
            'email' => $this->email,
            'tax_id' => $this->tax_id,
            'gender' => $this->gender,
            'priority' => $this->priority,
            'full_name' => $this->full_name,
            'last_name' => $this->last_name,
            'extension' => $this->extension,
            'company_id' => $this->company_id,
            'tax_regime' => $this->tax_regime,
            'profession' => $this->profession,
            'account_id' => $this->account_id,
            'first_name' => $this->first_name,
            'phone_home' => $this->phone_home,
            'birth_date'  => $this->birth_date,
            'birth_place' => $this->birth_place,
            'phone_office' => $this->phone_office,
            'phone_mobile' => $this->phone_mobile,
            'population_reg' => $this->population_reg,
            'pipeline_stage_id'  => $this->account_id,
            'principal_usage' => $this->principal_usage,
            'potential_value' => $this->potential_value,
            'second_last_name' => $this->second_last_name,
            'prospecting_mean_id' => $this->prospecting_mean_id,

            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_user_id' => $this->created_user_id,
            'updated_user_id' => $this->updated_user_id
        ];
    }
}
