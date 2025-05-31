<?php

namespace Modules\Town\Http\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\City\Http\Transformers\CityResource;
use Modules\District\Http\Transformers\DistrictResource;

class TownResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'slug'       => $this->slug,
            'district'   => new DistrictResource($this->whenLoaded('district')),
            'city'       => new CityResource($this->whenLoaded('city')),
        ];
    }
}

