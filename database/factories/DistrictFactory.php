<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\City\Http\Entities\City;
use Modules\District\Http\Entities\District;

class DistrictFactory extends Factory
{
    protected $model = District::class;

    public function definition(): array
    {
        $azerbaijanDistricts = [
            'Binəqədi', 'Nərimanov', 'Nizami', 'Xətai', 'Yasamal',
            'Səbail', 'Sabunçu', 'Suraxanı', 'Qaradağ', 'Nəsimi',
            'Abşeron'
        ];

        return [
            'slug' => $this->faker->unique()->slug,
            'name' => $this->faker->unique()->randomElement($azerbaijanDistricts),
            'city_id' => City::inRandomOrder()->first()?->id ?? 1,
        ];
    }
}
