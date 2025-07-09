<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
 {
         return [
            'name' => $this->faker->word(),
            'price' => $this->faker->randomFloat(2, 5, 500), 
            'currency' => $this->faker->randomElement(['EUR', 'USD']),
            'billing_type' => $this->faker->randomElement(['day', 'month', 'year']),
            'is_popular' => $this->faker->boolean(30), 
            'features' => json_encode([
                'Access to gym',
                'Free parking',
                'Personal trainer',
                'Sauna access'
            ]),
            'description' => $this->faker->sentence(10),
            'guest_passes_per_year' => $this->faker->numberBetween(0, 12),
        ];
    }}
    
}
