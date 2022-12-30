<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    private $subjects = [
        'Assunto 1',
        'Assunto 2',
        'Assunto 3',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->subjects as $subject) {
            Subject::create([
                'name' => $subject
            ]);
        }
    }
}
