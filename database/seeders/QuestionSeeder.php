<?php

namespace Database\Seeders;

use App\Models\Alternative;
use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Question::factory(10)
            ->has(Alternative::factory([
                'is_correct' => true,
                'letter' => 'A',
            ]))
            ->has(Alternative::factory([
                'is_correct' => false,
                'letter' => 'B',
            ]))
            ->has(Alternative::factory([
                'is_correct' => false,
                'letter' => 'C',
            ]))
            ->has(Alternative::factory([
                'is_correct' => false,
                'letter' => 'D',
            ]))
            ->has(Alternative::factory([
                'is_correct' => false,
                'letter' => 'E',
            ]))
            ->create();
    }
}
