<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Modules\Base\Enums\PropertyType;
use Modules\Base\Enums\RepairType;
use Modules\Base\Helpers\Enum;
use Modules\Base\Http\Entities\Subway;
use Modules\City\Http\Entities\City;
use Modules\District\Http\Entities\District;
use Modules\Property\Http\Entities\Property;
use Modules\Town\Http\Entities\Town;
use Modules\User\Http\Entities\User;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        return [
            'add_no' => $this->faker->randomNumber(),
            'slug' => $this->faker->slug(),
            'town_id' => Town::inRandomOrder()->first()->id,
            'subway_id' => Subway::inRandomOrder()->first()->id,
            'district_id' => District::inRandomOrder()->first()->id,
            'city_id' => City::inRandomOrder()->first()->id,
            'address' => City::inRandomOrder()->first()->name .' ' . District::inRandomOrder()->first()->name .' ' . Town::inRandomOrder()->first()->name,
            'property_condition' => $this->faker->randomElement(['0x001', '0x002']),
            'add_type' => $this->faker->randomElement(['sale', 'rent']),
            'number_of_floors' => $this->faker->numberBetween(0, 100),
            'number_of_rooms' => $this->faker->numberBetween(0, 20),
            'floor_located' => $this->faker->numberBetween(0, 100),
            'area' => $this->faker->numberBetween(0, 200),
            'field_area' => $this->faker->numberBetween(0, 1000),
            'advertiser' => $this->faker->randomNumber(),
            'advertiser_name' => $this->faker->name(),
            'phone_1' => $this->faker->phoneNumber(),
            'phone_2' => $this->faker->phoneNumber(),
            'phone_3' => $this->faker->phoneNumber(),
            'phone_4' => $this->faker->phoneNumber(),
            'mail' => $this->faker->email(),
            'description' => $this->faker->text(),
            'in_credit' => $this->faker->boolean(),
            'document' => $this->faker->randomNumber(),
            'note_to_admin' => $this->faker->text(),
            'building_type' => $this->faker->randomElement(['0x001', '0x002', '0x003', '0x004', '0x005', '0x006', '0x007', '0x008']),
            'has_video' => $this->faker->boolean(),
            'google_map_location' => $this->faker->localIpv4(),
            'is_active' => $this->faker->boolean(),
            'is_premium' => $this->faker->boolean(),
            'user_id' => User::inRandomOrder()->first()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ];
    }

}
