<?php

namespace Database\Factories;

use App\Models\Alternative;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Alternative>
 */
class AlternativeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $questions = collect(Question::all()->modelKeys());

        return [
            'question_id' => $questions->random(),
            'content' => fake()->sentence(),
            'letter' => fake()->randomElement(['A', 'B', 'C', 'D', 'E']),
            'is_correct' => false,
        ];
    }
}
