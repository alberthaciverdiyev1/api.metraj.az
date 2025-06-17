<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Base\Http\Entities\Subway;
use Modules\Blog\Http\Entities\Blog;
use Modules\Blog\Http\Entities\BlogCategory;
use Modules\Blog\Http\Entities\Tag;
use Modules\City\Http\Entities\City;
use Modules\District\Http\Entities\District;
use Modules\Feature\Http\Entities\Feature;
use Modules\Indicator\Http\Entities\Indicator;
use Modules\Keyword\Http\Entities\Keyword;
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
        Realtor::factory()->count(10)->create();

        Property::factory()->count(100)->create();

    }
}
