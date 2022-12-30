<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\QuestionSubject;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QuestionSubject>
 */
class QuestionSubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $questions = collect(Question::all()->modelKeys());
        $subjects = collect(Subject::all()->modelKeys());

        return [
            'question_id' => $questions->random(),
            'subject_id' => $subjects->random(),
        ];
    }
}
