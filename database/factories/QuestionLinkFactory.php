<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\QuestionLink;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuestionLink>
 */
class QuestionLinkFactory extends Factory
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
            'title' => fake()->sentence(),
            'url' => fake()->url(),
            'type' => fake()->randomElement(['Geral', 'Youtube']),
        ];
    }
}
