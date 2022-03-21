<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'meta_title' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(),
        ];
    }
}
