<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->streetName,
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(550,5000),
            'quantity' => $this->faker->numberBetween(1,500),
            'image' => $this->faker->imageUrl(600, 600, true),
        ];
    }
}
