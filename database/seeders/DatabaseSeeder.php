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
use Modules\Seo\Http\Entities\Seo;
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
                "path" => "https://bina.azstatic.com/uploads/full/2024%2F07%2F25%2F20%2F49%2F45%2Fe4f577c4-987b-4b39-bce9-d0575634a917%2F64677_XEKjwmAveF1J7d42VxCbsw.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F05%2F24%2F22%2F43%2F51%2F772fe031-5b13-42df-8784-165b0360ddde%2F66008_-f1hpkebL9FYqnHCOa3oWQ.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F07%2F22%2F11%2F30%2F55%2F6a32ad65-8d23-458b-83e7-d8c839dd21e1%2F4513_SdFmiiX51JZHxZnCDO0xMg.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F05%2F25%2F17%2F59%2F30%2Fdc955940-2c28-413a-941a-51fa2b3a08ec%2F92313_wLbwyJGJi75X1LikQGRJwg.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F05%2F25%2F17%2F59%2F37%2F4046075a-c330-4969-b2bd-3052fdb96836%2F4513_SdFmiiX51JZHxZnCDO0xMg.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F07%2F13%2F12%2F15%2F41%2Ffff1a6d2-7cc3-484d-a2aa-1d7a29e04afa%2F92313_wLbwyJGJi75X1LikQGRJwg.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F07%2F18%2F15%2F42%2F25%2Fa0893fa4-8f93-4e2f-a704-3e3b115ec40d%2F4513_SdFmiiX51JZHxZnCDO0xMg.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F07%2F18%2F16%2F01%2F35%2F4e65b16e-2879-414d-a484-64038bc95cb0%2F92313_wLbwyJGJi75X1LikQGRJwg.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F06%2F03%2F22%2F21%2F35%2F8c51d790-8e12-4aad-82c0-5b657b23c7a5%2F92313_wLbwyJGJi75X1LikQGRJwg.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F07%2F22%2F11%2F33%2F42%2Fcbbf121c-3df4-407d-9ec2-3db59751c53b%2F4513_SdFmiiX51JZHxZnCDO0xMg.jpg"
            ],
            //
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F07%2F03%2F23%2F25%2F15%2Fde293709-dfcf-4f5c-8ef7-e6b5c321c7be%2F92313_wLbwyJGJi75X1LikQGRJwg.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F03%2F23%2F16%2F35%2F03%2Fecd5179f-feb9-4ae9-831d-fdf23e7a737f%2F97099_EJ72UhgXp-49okZGEgL6Ig.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F07%2F18%2F11%2F47%2F11%2F1a8668a1-7668-4ebf-bad4-b98e21b183a3%2F4513_SdFmiiX51JZHxZnCDO0xMg.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F07%2F12%2F11%2F30%2F04%2F173b18fe-f435-4565-9134-f4b122513eed%2F92313_wLbwyJGJi75X1LikQGRJwg.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F07%2F22%2F11%2F41%2F50%2F86545742-0029-4b14-ab36-476f4abade2e%2F92313_wLbwyJGJi75X1LikQGRJwg.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F01%2F12%2F13%2F33%2F48%2Fe52433c1-b216-43ef-971d-49e59837ba28%2F67900_VsfyEqu9G0cxtdUTwCN1tQ.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F07%2F08%2F01%2F40%2F48%2F3d14c789-0592-451f-b91b-7803e02991f8%2F92313_wLbwyJGJi75X1LikQGRJwg.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F07%2F18%2F18%2F27%2F39%2F3f0a2f9a-6163-4100-a399-9c7f9ee99fe0%2F66008_-f1hpkebL9FYqnHCOa3oWQ.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F07%2F22%2F10%2F23%2F48%2Fca57391b-f4b2-4508-9f4a-4837f4fd0a3b%2F92313_wLbwyJGJi75X1LikQGRJwg.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://bina.azstatic.com/uploads/full/2025%2F06%2F27%2F13%2F02%2F32%2Fb01633c8-d24f-4bdd-a5d8-0942a1a113cd%2F66008_-f1hpkebL9FYqnHCOa3oWQ.jpg"
            ],
            [
                "type" => "video",
                "path" => "https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/TearsOfSteel.mp4"
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
        User::factory()->count(100)->create();
        Seo::factory()->count(5)->create();
        Tag::factory()->count(1000)->create();
        BlogCategory::factory()->count(10)->create();
        Blog::factory()->count(50)->create();
        Nearby::factory()->count(99)->create();

        $properties = Property::factory(100)->create();

        $properties->each(function ($property) use ($mediaData) {

            Price::create([
                'property_id' => $property->id,
                'price' => rand(500, 1000000),
                'currency' => Enum::check(Currency::class, 'AZN'),
            ]);

            $nearbyIds = Nearby::inRandomOrder()->limit(rand(3, 20))->pluck('id');
            $property->nearbyObjects()->attach($nearbyIds);

            $shuffledMedia = collect($mediaData)
                ->shuffle()
                ->sortBy(function ($item) {
                    return $item['type'] === 'video' ? 1 : 0;
                })
                ->values()
                ->all();

            $property->media()->createMany($shuffledMedia);
            $property->features()->attach(Feature::inRandomOrder()->limit(rand(3, 20))->pluck('id'));
        });
    }
}
