<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Doctor extends JsonResource
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
            'id'              => $this->id,
            'fisrt_name'      => $this->first_name,
            'last_name'       => $this->last_name,
            'register_number' => $this->register_number,
            'complete_name'   => $this->first_name.' '.$this->last_name. ' #REG: '.$this->register_number
        ];
    }
}
