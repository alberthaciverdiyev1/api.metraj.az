<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Base\Http\Entities\Subway;

class SubwayFactory extends Factory
{
    protected $model = Subway::class;
    public function definition(): array
    {
        $azerbaijanSubways = [
            '28 May', 'Gənclik', 'Nəriman Nərimanov', 'Ulduz', 'Xalqlar Dostluğu',
            'Neftçilər', 'Koroğlu', 'Əcəmi', 'Nəsimi', 'Elmlər Akademiyası',
            'İnşaatçılar', '20 Yanvar', 'Memar Əcəmi', 'Avtovağzal',
            'Həzi Aslanov', 'Bakmil', 'Qara Qarayev', 'Xətai', 'Şah İsmayıl Xətai',
            'İçərişəhər', 'Sahil', 'Nizami', 'Cəfər Cabbarlı', 'Azadlıq Prospekti'
        ];

        $name = $this->faker->unique()->randomElement($azerbaijanSubways);

        return [
            'slug' => \Illuminate\Support\Str::slug($name) . '-' . $this->faker->unique()->numberBetween(100, 999),
            'name' => $name,
        ];
    }
}
