<?php

namespace Modules\User\Http\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'email'             => $this->email,
            'address'           => $this->address,
            'subway_id'         => $this->subway_id,
            'district_id'       => $this->district_id,
            'city_id'           => $this->city_id,
            'town_id'           => $this->town_id,
            'phone_1'           => $this->phone_1,
            'phone_2'           => $this->phone_2,
            'phone_3'           => $this->phone_3,
            'phone_4'           => $this->phone_4,
            'is_active'         => $this->is_active,
            'is_premium'        => $this->is_premium,
            'is_confirmed'      => $this->is_confirmed,
            'is_agency'         => $this->is_agency,
            'profile_image'     => $this->profile_image,
            'background_image'  => $this->background_image,
            'short_description' => $this->short_description,
            'work_hours'        => $this->work_hours,

            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
        ];
    }

}

