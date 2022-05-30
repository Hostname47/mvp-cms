<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
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
            'title_meta' => $this->faker->sentence(),
            'slug' => $this->faker->slug(),
            'summary' => $this->faker->text(),
            'content' => $this->faker->text(),
            'visibility' => 'public',
            'status' => 'published'
        ];
    }
}
