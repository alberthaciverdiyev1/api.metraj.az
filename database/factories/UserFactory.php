<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Modules\Base\Http\Entities\Subway;
use Modules\City\Http\Entities\City;
use Modules\District\Http\Entities\District;
use Modules\Town\Http\Entities\Town;
use Modules\User\Http\Entities\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'address' => $this->faker->address(),
            'subway_id' => Subway::inRandomOrder()->first()->id,
            'district_id' => District::inRandomOrder()->first()->id,
            'city_id' => City::inRandomOrder()->first()->id,
            'town_id' => Town::inRandomOrder()->first()->id,
            'phone_1' => $this->faker->phoneNumber(),
            'phone_2' => $this->faker->phoneNumber(),
            'phone_3' => $this->faker->phoneNumber(),
            'phone_4' => $this->faker->phoneNumber(),
            'is_active' => $this->faker->boolean(),
            'is_premium' => $this->faker->boolean(),
            'is_confirmed' => $this->faker->boolean(),
            'password' => Hash::make('password'),
        ];
    }
}
