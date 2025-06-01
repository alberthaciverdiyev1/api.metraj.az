<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Modules\Base\Http\Entities\Subway;
use Modules\City\Http\Entities\City;
use Modules\District\Http\Entities\District;
use Modules\Property\Http\Entities\Property;
use Modules\Realtor\Http\Entities\Realtor;
use Modules\Town\Http\Entities\Town;
use Modules\User\Http\Entities\User;

class RealtorFactory extends Factory
{
    protected $model = Realtor::class;

    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug(),
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'user_id' => User::inRandomOrder()->first()->id,
            'subway_id' => Subway::inRandomOrder()->first()->id,
            'district_id' => District::inRandomOrder()->first()->id,
            'city_id' => City::inRandomOrder()->first()->id,
            'town_id' => Town::inRandomOrder()->first()->id,
            'phone_1' => $this->faker->phoneNumber(),
            'phone_2' => $this->faker->phoneNumber(),
            'phone_3' => $this->faker->phoneNumber(),
            'phone_4' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'is_active' => $this->faker->boolean(),
            'is_premium' => $this->faker->boolean(),
            'is_confirmed' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

}
