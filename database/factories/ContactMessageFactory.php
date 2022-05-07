<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ip' => $this->faker->ipv4(),
            'firstname' => $this->faker->name,
            'lastname' => $this->faker->name,
            'email' => $this->faker->email,
            'message' => $this->faker->text(),
        ];
    }
}
