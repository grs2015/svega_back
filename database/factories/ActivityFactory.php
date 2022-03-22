<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->word(),
            'subtitle' => $this->faker->paragraph(1),
            'section_title_1' => $this->faker->sentence(3),
            'section_description_1' => $this->faker->paragraph(2),
            'section_title_2' => $this->faker->sentence(3),
            'section_description_2' => $this->faker->paragraph(2),
            'section_title_3' => $this->faker->sentence(3),
            'section_description_3' => $this->faker->paragraph(2),
            'image' => $this->faker->imageUrl(1280, 200)
        ];
    }
}
