<?php

namespace Modules\Ad\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Ad\Http\Entities\Ad;
use Modules\User\Http\Entities\User;

class AdFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ad::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'agency_id' => User::factory()->state(['is_agency' => true]),
            'image' => $this->faker->imageUrl(800, 600, 'advertisement'),
            'deactive_date' => $this->faker->dateTimeBetween('now', '+30 days'),
            'is_active' => $this->faker->boolean(60), // 60% chance of being active
        ];
    }
}
