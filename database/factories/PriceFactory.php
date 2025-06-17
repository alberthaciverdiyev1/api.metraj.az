<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\District\Http\Entities\District;
use Modules\Price\Http\Entities\Price;
use Modules\Property\Http\Entities\Property;

class PriceFactory extends Factory
{
    protected $model = Price::class;

    public function definition(): array
    {

        return [
            'property_id' => Property::inRandomOrder()->first()?->id ?? 1,
            'price' => $this->faker->numberBetween(100, 100000),
            'currency' => '0x001',
        ];
    }
}
