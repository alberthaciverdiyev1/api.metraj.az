<?php

namespace Modules\Property\Http\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Modules\Media\Http\Transformers\MediaResource;
use Modules\Price\Http\Transformers\PriceResource;

class PropertyListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getAttribute('id'),
            'slug' => $this->getAttribute('slug'),
            'date' => \Carbon\Carbon::parse($this->getAttribute('date'))->format('d F, Y'),
            'title' => $this->number_of_rooms .' otaqlı '. $this->subway->name ?? $this->district->name,
            'address' => $this->getAttribute('address'),
            'beds' => 4,
            'baths' => 3,
            'area' => $this->getAttribute('area'),
            'price' => PriceResource::collection($this->prices),
            'media' => $this->media->isNotEmpty() ? MediaResource::make($this->media->first()) : 'https://static.vecteezy.com/system/resources/previews/004/640/986/non_2x/tower-building-illustration-isolated-on-white-background-vector.jpg',
        ];
    }
}
