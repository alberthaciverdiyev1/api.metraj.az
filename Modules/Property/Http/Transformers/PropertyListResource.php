<?php

namespace Modules\Property\Http\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertyListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getAttribute('id'),
            'name' => $this->getAttribute('name'),
            'slug' => $this->getAttribute('slug'),
            'date' => \Carbon\Carbon::parse($this->getAttribute('date'))->format('d F, Y'),
            'image' => 'https://themesflat.co/html/proty/images/section/box-house-16.jpg',
            'title' => $this->number_of_rooms . $this->subway->name ?? $this->district->name,

            'address' => '102 Ingraham St, Brooklyn, NY 11237',
            'beds' => 4,
            'baths' => 3,
            'area' => '4,043',
            'price' => '8,600',
            'video' => 'https://www.youtube.com/embed/MLpWrANjFbI',

            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam risus leo, blandit vitae diam a, vestibulum viverra nisi. Vestibulum ullamcorper velit eget mattis aliquam. Proin dapibus luctus pulvinar. Integer et libero ut purus bibendum gravida non ac tellus.

Aliquam non lorem consequat, luctus dui et, auctor nisi. Aenean placerat sapien at augue lacinia, non semper urna tempor. Mauris sit amet elit orci',
            'altimages' => [
                'first_image' => 'webui/images/property-detail-3.jpg',
                'second_image' => 'webui/images/property-detail-4.jpg',
                'third_image' => 'webui/images/property-detail-5.jpg',
                'fourth_image' => 'webui/images/property-detail-6.jpg'
            ],
            'details' => [
                'units' => '3 Units in North Hollywood with upside potential through construction of an ADU (buyer to verify).',
                'unit_mix' => '(3) 3+1 bath units',
                'building_size' => '2,660 sqft',
                'lot_size' => '6,001 sqft',
                'access' => 'Easy access to the 101, 170, and 134 freeways.',
                'metering' => 'Separately metered for gas and electricity',
            ],
            'extra' => [
                'id' => '1234',
                'price_text' => '$7,500',
                'size' => '150 sqft',
                'rooms' => 9,
                'beds_exact' => 7.328,
                'year_built' => 2022,
                'type' => 'Villa',
                'status' => 'For sale',
                'garage' => 3,
                'rent_price' => '$250,00 /month',
            ],
            'amenities' => [
                'Smoke alarm',
                'Carbon monoxide alarm',
                'First aid kit',
                'Self check-in with lockbox',
                'Security cameras',
                'Hangers',
                'Bed linens',
                'Extra pillows & blankets',
                'Iron',
                'TV with standard cable',
                'Refrigerator',
                'Microwave',
                'Dishwasher',
                'Coffee maker',
            ],


            'floor_plan' => [
                [
                    'floor' => 'First Floor',
                    'bedrooms' => 2,
                    'bathrooms' => 3,
                    'image' => 'https://themesflat.co/html/proty/images/section/floor.jpg',
                ],
                [
                    'floor' => 'Second Floor',
                    'bedrooms' => 1,
                    'bathrooms' => 5,
                    'image' => 'https://themesflat.co/html/proty/images/section/floor.jpg',
                ],
            ],

            'nearby' => [

                'School' => '0.7 km',
                'University' => '1.3 km',
                'Grocery center' => '0.6 km',
                'Market' => '1.1 km',
            ],
            'map' => [
                'latitude' => 40.5812895,
                'longitude' => 49.6735533,
                'address' => 'Sumgait beach',
                'city' => 'Sumgait',
                'state' => 'Absheron',
                'postal_code' => 'AZ5000',
                'area' => 7345,
                'country' => 'Azerbaijan',
            ],
            'virtual_tour' => [
                'link' => 'https://www.youtube.com/embed/MLpWrANjFbI',
                'image' => 'https://themesflat.co/html/proty/images/section/property-detail-2.jpg',
            ],
            'comments' => [],


        ];
    }
}
