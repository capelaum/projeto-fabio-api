<?php

namespace Database\Seeders;

use App\Models\AnsweredQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnsweredQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AnsweredQuestion::factory(10)->create();
    }
}
