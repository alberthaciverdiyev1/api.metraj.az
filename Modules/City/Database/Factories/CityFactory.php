<?php

namespace Modules\City\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Modules\City\Http\Entities\City;

class CityFactory extends Factory
{
    protected $model = City::class;

    public function definition(): array
    {
        $cities = [
            'Bakı', 'Gəncə', 'Sumqayıt', 'Mingəçevir', 'Şəki',
            'Şirvan', 'Lənkəran', 'Yevlax', 'Naftalan', 'Xankəndi',
            'Quba', 'Qusar', 'Zaqatala', 'Qax', 'Ağdaş',
            'Tovuz', 'Şəmkir', 'Qazax', 'Masallı', 'Salyan',
            'Sabirabad', 'İmişli', 'Bərdə', 'Ağcabədi', 'Zərdab',
            'Naxçıvan', 'Ordubad', 'Şahbuz', 'Culfa', 'Şuşa'
        ];

        return [
            'name' => $this->faker->randomElement($cities),
            'is_active' => $this->faker->boolean(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
