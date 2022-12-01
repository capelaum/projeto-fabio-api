<?php

namespace Database\Seeders;

use App\Models\Discipline;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            DisciplineSeeder::class,
            QuestionSeeder::class,
            QuestionLinkSeeder::class,
            SubjectSeeder::class,
            QuestionSubjectSeeder::class,
        ]);
    }
}
