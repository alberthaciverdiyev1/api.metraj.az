<?php

namespace Modules\Property\Http\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Modules\Price\Http\Transformers\PriceResource;

class PropertyListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $images = [
            'https://media.istockphoto.com/id/1390233984/photo/modern-luxury-bedroom.jpg?s=612x612&w=0&k=20&c=po91poqYoQTbHUpO1LD1HcxCFZVpRG-loAMWZT7YRe4=',
            'https://assets.architecturaldigest.in/photos/621f43c6fa7af6911e95b64a/16:9/w_1280,c_limit/7%20budget-friendly%20kids%E2%80%99%20room%20design%20ideas.jpg',
            'https://media.designcafe.com/wp-content/uploads/2023/07/05141750/aesthetic-room-decor.jpg',
            'https://www.thespruce.com/thmb/2_Q52GK3rayV1wnqm6vyBvgI3Ew=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/put-together-a-perfect-guest-room-1976987-hero-223e3e8f697e4b13b62ad4fe898d492d.jpg',
            'https://www.brightonhomes.net.au/sites/default/files/styles/blog_hero_banner/public/what-is-a-rumpus-room.jpg?itok=Df0VIb-y',
            'https://www.realsimple.com/thmb/oO5rVtxCPEdBMVmVRLN0Ag-uELY=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/LivingRoom_0288-real-simple-home-2023-0923fea-1fbd00fca003419b8ef5bdb11d95187c.jpg',
            'https://www.gentinghotel.co.uk/_next/image?url=https%3A%2F%2Fs3.eu-west-2.amazonaws.com%2Fstaticgh.gentinghotel.co.uk%2Fuploads%2Fhero%2FSuiteNov2022_0008_1920.jpg&w=3840&q=75',
            'https://www.ikea.com/images/a-shared-childrens-room-with-two-beds-where-some-mammut-chil-548e7eb28566d8edb960f3297cc57e09.jpg?f=xl',
            'https://mustardmade.com/cdn/shop/articles/Colourful_kids_rooms_1200x.png?v=1713928416',
            'https://rnb.scene7.com/is/image/roomandboard/arro_529831_24e?size=2400,2400&scl=1',
            'https://media.designcafe.com/wp-content/uploads/2020/05/17174742/childrens-bedroom-with-bunk-bed-and-seating-area.jpg'
        ];
        return [
            'id' => $this->getAttribute('id'),
            'slug' => $this->getAttribute('slug'),
            'date' => \Carbon\Carbon::parse($this->getAttribute('date'))->format('d F, Y'),
            'image' => Arr::random($images),
            'title' => $this->number_of_rooms .' otaqlı '. $this->subway->name ?? $this->district->name,
            'address' => $this->getAttribute('address'),
            'beds' => 4,
            'baths' => 3,
            'area' => $this->getAttribute('area'),
            'price' => PriceResource::collection($this->prices),
        ];
    }
}
