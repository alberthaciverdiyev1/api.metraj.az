<?php

namespace Modules\Property\Http\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Base\Enums\PropertyType;
use Modules\Base\Enums\RepairType;
use Modules\Base\Helpers\Enum;
use Modules\Base\Http\Transformers\SubwayResource;
use Modules\City\Http\Transformers\CityResource;
use Modules\District\Http\Transformers\DistrictResource;
use Modules\Feature\Http\Transformers\FeatureResource;
use Modules\Media\Http\Transformers\MediaResource;
use Modules\Price\Http\Transformers\PriceResource;
use function Symfony\Component\Translation\t;

class PropertyDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->number_of_rooms . ' otaqlı ' . $this->subway->name ?? $this->district->name,
            'prices' => PriceResource::collection($this->prices),
            'add_no' => $this->add_no,
            'slug' => $this->slug,
            'address' => $this->address,
            'description' => $this->description,
            'date' => \Carbon\Carbon::parse($this->getAttribute('date'))->format('d F, Y'),
            'area' => $this->area,
            'field_area'=> $this->field_area,
            'media' => [
                'images' => MediaResource::collection($this->media->where('type', 'image')) ?? null,
                'video'  => MediaResource::collection($this->media->where('type', 'video')) ?? null,
                'document'  => MediaResource::collection($this->media->where('type', 'document'))  ?? null,
            ],

            'property_condition' => Enum::resolve(RepairType::class,$this->property_condition),

            'add_type' => $this->add_type,
            'number_of_floors' => $this->number_of_floors,
            'number_of_rooms' => $this->number_of_rooms,
            'floor_located' => $this->floor_located,
            'advertiser' => $this->advertiser,
            'advertiser_name' => $this->advertiser_name,
            'phone_1' => $this->phone_1,
            'phone_2' => $this->phone_2,
            'phone_3' => $this->phone_3,
            'phone_4' => $this->phone_4,
            'mail' => $this->mail,
            'in_credit' => $this->in_credit,
            'note_to_admin' => $this->note_to_admin,
            'building_type' => Enum::resolve(PropertyType::class,$this->building_type),
            'has_video' => $this->has_video,
            'is_active' => $this->is_active,
            'is_premium' => $this->is_premium,
            'features' => FeatureResource::collection($this->features),
            'location' => [
                //            'town_id',
                'subway' => SubwayResource::make($this->subway),
                'city' => CityResource::make($this->city),
                'district' => DistrictResource::make($this->district),
                'google_map_location' => $this->google_map_location ?? null,
                'address' => $this->address ?? 'Not specified',

            ],
            'virtual_tour' => [
                'link' => 'https://www.youtube.com/embed/MLpWrANjFbI',
                'image' => 'https://themesflat.co/html/proty/images/section/property-detail-2.jpg',
            ],
            'nearby_objects' => [
                ['range' => '1km',
                    'name' => 'Araz Market'
                ],
                [
                    'range' => '100m',
                    'name' => 'Bravo Supermarket'
                ],
                [
                    'range' => '1km',
                    'name' => 'Inshaatcilar m-su'
                ]
            ],
//            'user_id' ,
//            'realtor_id',
        ];
    }
}
