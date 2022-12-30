<?php

namespace Database\Seeders;

use App\Models\Discipline;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DisciplineSeeder extends Seeder
{
    private $disciplines = [
        'Geral',
        'Matemática'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->disciplines as $discipline) {
            Discipline::create([
                'name' => $discipline
            ]);
        }
    }
}
