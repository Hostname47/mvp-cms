<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TagFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'title_meta' => $this->faker->unique()->sentence(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->sentence(),
        ];
    }
}
