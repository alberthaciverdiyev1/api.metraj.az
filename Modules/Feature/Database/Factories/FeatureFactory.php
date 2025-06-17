<?php

namespace Modules\Feature\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Feature\Http\Entities\Feature;

class FeatureFactory extends Factory
{
    protected $model = Feature::class;

    protected array $features = [
        'Eyvan',
        'Kondisioner',
        'Avtomobil dayanacağı',
        'Üzgüçülük hovuzu',
        'Bağça',
        'Təhlükəsizlik',
        'Lift',
        'Qapalı qaraj',
        'Uşaq oyun meydançası',
        'Fitness zalı',
        'İsitmə sistemi',
        'Anbar sahəsi',
        'Mətbəx mebeli',
        'İnternet',
        'Kabel televiziyası',
        'Təmiz su',
        'Qaz',
        'Kombi sistemi',
        'Park',
        'Təmiz hava',
        'Qapalı balkon',
        'Sahə hovuzu',
        'Qazanın idarəetməsi',
        'Dəmir qapı',
        'Su təchizatı',
        'Telefon xətti',
        'Əlillər üçün əlçatanlıq',
        'Yanğın siqnalizasiya',
        'Video nəzarət',
        'Mərkəzləşdirilmiş istilik',
        'Yüksək sürətli lift',
        'Günəş işığı',
        'Döşəmə isidilməsi',
        'Ev heyvanlarına icazə',
    ];

    public function definition(): array
    {
        $name = $this->faker->randomElement($this->features);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
