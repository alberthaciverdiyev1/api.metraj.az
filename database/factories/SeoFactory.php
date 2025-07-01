<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\District\Http\Entities\District;
use Modules\Seo\Http\Entities\Seo;
use Modules\Town\Http\Entities\Town;
use Modules\User\Http\Entities\User;

class SeoFactory extends Factory
{
    protected $model = Seo::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->slug,
            'description' => $this->faker->sentence(),
            'meta_tags' => $this->faker->text(),
            'other_codes' => $this->faker->text(),
            'user_id' => User::inRandomOrder()->first()?->id ?? 1,
            'is_active' => $this->faker->boolean(100),
            'page' => $this->faker->randomElement(['/','property','contact','agencies','blog','about-us'])
        ];
    }
}
