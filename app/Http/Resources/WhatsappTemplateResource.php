<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WhatsappTemplateResource extends JsonResource
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
            'raw_value' => $this->raw_value,
            'table_name' => $this->table_name,
            'replace_type' => $this->replace_type,
            'table_column' => $this->table_column,
            'template_name' => $this->template_name,
            'dynamic_index' => $this->dynamic_index
        ];
    }
}
