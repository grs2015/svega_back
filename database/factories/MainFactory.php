<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MainFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'main_title' => $this->faker->catchPhrase(),
            'main_image' => $this->faker->imageUrl(1280, 400),
            'parallax_images' => implode(',', array($this->faker->imageUrl(1280, 400), $this->faker->imageUrl(1280, 400))),
            'company_name' => $this->faker->company(),
            'company_data' => implode(',', $this->faker->words()),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->safeEmail(),
            'website' => $this->faker->domainName()
        ];
    }
}
