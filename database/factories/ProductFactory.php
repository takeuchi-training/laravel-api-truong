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
            'name' => $this->faker->words($nb = 2, $asText = true),
            'slug' => $this->faker->slug($nbWords = 3),
            'description' => $this->faker->sentences($nb = 6, $asText = true),
            'price' => $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 999)
        ];
    }
}
