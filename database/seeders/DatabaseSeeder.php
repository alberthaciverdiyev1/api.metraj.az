<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Base\Enums\Currency;
use Modules\Base\Helpers\Enum;
use Modules\Base\Http\Entities\Subway;
use Modules\Blog\Http\Entities\Blog;
use Modules\Blog\Http\Entities\BlogCategory;
use Modules\Blog\Http\Entities\Tag;
use Modules\City\Http\Entities\City;
use Modules\District\Http\Entities\District;
use Modules\Feature\Http\Entities\Feature;
use Modules\Indicator\Http\Entities\Indicator;
use Modules\Keyword\Http\Entities\Keyword;
use Modules\Nearby\Http\Entities\Nearby;
use Modules\Price\Http\Entities\Price;
use Modules\Property\Http\Entities\Property;
use Modules\Realtor\Http\Entities\Realtor;
use Modules\Setting\Http\Entities\Setting;
use Modules\Town\Http\Entities\Town;
use Modules\User\Http\Entities\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $mediaData = [
            [
                "type" => "image",
                "path" => "https://www.motoroids.com/wp-content/uploads/2014/10/hyundai-genesis-coupe-btr-1200x820.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://fastly.picsum.photos/id/10/2500/1667.jpg?hmac=J04WWC_ebchx3WwzbM-Z4_KC_LeLBWr5LZMaAkWkF68"
            ],
            [
                "type" => "image",
                "path" => "https://fastly.picsum.photos/id/15/2500/1667.jpg?hmac=Lv03D1Y3AsZ9L2tMMC1KQZekBVaQSDc1waqJ54IHvo4"
            ],
            [
                "type" => "image",
                "path" => "https://fastly.picsum.photos/id/20/3670/2462.jpg?hmac=CmQ0ln-k5ZqkdtLvVO23LjVAEabZQx2wOaT4pyeG10I"
            ],
            [
                "type" => "image",
                "path" => "https://fastly.picsum.photos/id/22/4434/3729.jpg?hmac=fjZdkSMZJNFgsoDh8Qo5zdA_nSGUAWvKLyyqmEt2xs0"
            ],
            [
                "type" => "image",
                "path" => "https://fastly.picsum.photos/id/23/3887/4899.jpg?hmac=2fo1Y0AgEkeL2juaEBqKPbnEKm_5Mp0M2nuaVERE6eE"
            ],
            [
                "type" => "image",
                "path" => "https://fastly.picsum.photos/id/25/5000/3333.jpg?hmac=yCz9LeSs-i72Ru0YvvpsoECnCTxZjzGde805gWrAHkM"
            ],
            [
                "type" => "image",
                "path" => "https://fastly.picsum.photos/id/24/4855/1803.jpg?hmac=ICVhP1pUXDLXaTkgwDJinSUS59UWalMxf4SOIWb9Ui4"
            ],
            [
                "type" => "image",
                "path" => "https://fastly.picsum.photos/id/19/2500/1667.jpg?hmac=7epGozH4QjToGaBf_xb2HbFTXoV5o8n_cYzB7I4lt6g"
            ],
            [
                "type" => "video",
                "path" => "http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ForBiggerBlazes.mp4"
            ],
        ];

        City::factory()->count(10)->create();
        Feature::factory()->count(30)->create();
        District::factory()->count(10)->create();
        Indicator::factory()->count(100)->create();
        Subway::factory()->count(20)->create();
        Town::factory()->count(10)->create();
        Setting::factory()->count(1)->create();
        Keyword::factory()->count(10)->create();
        User::factory()->count(10)->create();
        Tag::factory()->count(1000)->create();
        BlogCategory::factory()->count(10)->create();
        Blog::factory()->count(50)->create();
        Nearby::factory()->count(99)->create();
        Property::factory()->count(100)->create();
        Price::factory()->count(100)->create();
        Property::factory(50)->create()->each(function ($property) use ($mediaData) {

            Price::create([
                'property_id' => $property->id,
                'price' => rand(500, 1000000),
                'currency' => Enum::check(Currency::class, 'AZN'),
            ]);

            $nearbyIds = Nearby::inRandomOrder()->limit(rand(3, 20))->pluck('id');
            $property->nearbyObjects()->attach($nearbyIds);

            $shuffledMedia = collect($mediaData)
                ->shuffle()
                ->sortBy(function ($item, $key) {
                    return $item['type'] === 'video' ? 1 : 0;
                })
                ->values()
                ->all();

            $property->media()->createMany($shuffledMedia);
            $property->features()->attach(Feature::inRandomOrder()->limit(rand(3, 20))->pluck('id'));
        });

    }
}
