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
        $mediaData = [
            [
                "type" => "image",
                "path" => "https://www.motoroids.com/wp-content/uploads/2014/10/hyundai-genesis-coupe-btr-1200x820.jpg"
            ],
            [
                "type" => "image",
                "path" => "https://fastly.picsum.photos/id/10/2500/1667.jpg?hmac=J04WWC_ebchx3WwzbM-Z4_KC_LeLBWr5LZMaAkWkF68"
            ],
            [
                "type" => "image",
                "path" => "https://fastly.picsum.photos/id/15/2500/1667.jpg?hmac=Lv03D1Y3AsZ9L2tMMC1KQZekBVaQSDc1waqJ54IHvo4"
            ],
            [
                "type" => "image",
                "path" => "https://fastly.picsum.photos/id/20/3670/2462.jpg?hmac=CmQ0ln-k5ZqkdtLvVO23LjVAEabZQx2wOaT4pyeG10I"
            ],
            [
                "type" => "image",
                "path" => "https://fastly.picsum.photos/id/22/4434/3729.jpg?hmac=fjZdkSMZJNFgsoDh8Qo5zdA_nSGUAWvKLyyqmEt2xs0"
            ],
            [
                "type" => "image",
                "path" => "https://fastly.picsum.photos/id/23/3887/4899.jpg?hmac=2fo1Y0AgEkeL2juaEBqKPbnEKm_5Mp0M2nuaVERE6eE"
            ],
            [
                "type" => "image",
                "path" => "https://fastly.picsum.photos/id/25/5000/3333.jpg?hmac=yCz9LeSs-i72Ru0YvvpsoECnCTxZjzGde805gWrAHkM"
            ],
            [
                "type" => "image",
                "path" => "https://fastly.picsum.photos/id/24/4855/1803.jpg?hmac=ICVhP1pUXDLXaTkgwDJinSUS59UWalMxf4SOIWb9Ui4"
            ],
            [
                "type" => "image",
                "path" => "https://fastly.picsum.photos/id/19/2500/1667.jpg?hmac=7epGozH4QjToGaBf_xb2HbFTXoV5o8n_cYzB7I4lt6g"
            ]
        ];

        $randomImages = array_values($mediaData);

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
            'is_agency' => $this->faker->boolean(30),
            'profile_image' => $this->faker->randomElement($randomImages)['path'],
            'background_image' => $this->faker->randomElement($randomImages)['path'],
            'short_description' => $this->faker->text(),
            'password' => Hash::make('password'),
        ];
    }
}
