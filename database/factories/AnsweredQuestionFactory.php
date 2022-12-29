<?php

namespace Database\Factories;

use App\Models\Alternative;
use App\Models\AnsweredQuestion;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AnsweredQuestion>
 */
class AnsweredQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $users = collect(User::all()->modelKeys());
        $questions = collect(Question::all()->modelKeys());
        $alternatives = collect(Alternative::all()->modelKeys());

        return [
            'user_id' => $users->random(),
            'question_id' => $questions->random(),
            'alternative_id' => $alternatives->random(),
            'is_correct' => fake()->boolean()
        ];
    }
}
