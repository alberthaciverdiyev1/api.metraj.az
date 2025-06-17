<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\District\Http\Entities\District;
use Modules\Town\Http\Entities\Town;

class TownFactory extends Factory
{
    protected $model = Town::class;

    public function definition(): array
    {
        $azerbaijanTowns = [
            'Biləcəri', 'Əhmədli', 'Hövsan', 'Binə', 'Zabrat',
            'Kürdəxanı', 'Masazır', 'Xırdalan', 'Sarayevo', 'Buzovna',
            'Qala', 'Məmmədli', 'Nardaran', 'Novxanı', 'Sumqayıt qəsəbəsi',
            'Lökbatan', 'Qobustan', 'Şamaxı kəndi', 'Sabunçu kəndi', 'Zirə',
            'Türkan', 'Pirallahı', 'Qalaaltı', 'Qobustan kəndi', 'Hacıqabul'
        ];

        return [
            'slug' => $this->faker->unique()->slug,
            'name' => $this->faker->unique()->randomElement($azerbaijanTowns),
            'district_id' => District::inRandomOrder()->first()?->id ?? 1,
        ];
    }
}
