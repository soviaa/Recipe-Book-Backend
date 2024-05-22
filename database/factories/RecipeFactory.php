<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Recipe>
 */
class RecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'prep_time' => $this->faker->numberBetween(10, 60),
            'cook_time' => $this->faker->numberBetween(10, 120),
            'servings' => $this->faker->numberBetween(1, 8),
            'difficulty' => $this->faker->randomElement(['Easy', 'Medium', 'Hard']),
            'recipe_type' => $this->faker->randomElement(['Breakfast', 'Lunch', 'Dinner', 'Snack']),
            'image' => $this->faker->imageUrl(),
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'is_private' => $this->faker->boolean,
            'is_approved' => $this->faker->boolean,
        ];
    }
}
