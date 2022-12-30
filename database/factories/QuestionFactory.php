<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Discipline;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $disciplines = collect(Discipline::all()->modelKeys());
        $categories = collect(Category::all()->modelKeys());

        return [
            'discipline_id' => $disciplines->random(),
            'category_id' => $categories->random(),
            'title' => fake()->sentence(),
            'content' => fake()->paragraph(),
            'year' => fake()->numberBetween(2018, 2022),
            'is_active' => fake()->boolean(),
        ];
    }
}
