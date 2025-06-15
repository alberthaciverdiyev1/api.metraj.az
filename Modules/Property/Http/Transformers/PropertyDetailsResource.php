<?php

namespace Modules\Property\Http\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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
            'price' => '400',
            'add_no' => $this->add_no,
            'slug' => $this->slug,
            'address' => $this->address,
            'description' => $this->description,
            'date' => \Carbon\Carbon::parse($this->getAttribute('date'))->format('d F, Y'),
            'area' => $this->area,
            'field_area' => $this->field_area,

//            'image'=>$this->image()
            'images' => [
                'https://themesflat.co/html/proty/images/blog/blog-grid-1.jpg',
                'https://themesflat.co/html/proty/images/blog/blog-grid-2.jpg',
                'https://themesflat.co/html/proty/images/blog/blog-grid-3.jpg',
                'https://themesflat.co/html/proty/images/blog/blog-grid-4.jpg',
            ],

            'video' => 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/SubaruOutbackOnStreetAndDirt.mp4',
            'document' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',

            'property_type' => $this->property_type,
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
            'building_type' => $this->building_type,
            'has_video' => $this->has_video,
            'is_active' => $this->is_active,
            'is_premium' => $this->is_premium,
            'features' => ["test", 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test', 'test'],
            'location' => [
                //            'town_id',
//            'subway_id',
//            'district_id' => ,
//            'city_id',
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
