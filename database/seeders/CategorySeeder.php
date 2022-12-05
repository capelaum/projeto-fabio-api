<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    const PLACEHOLDER = 'https://dummyimage.com/80x80/fff/333';

    private $categories = [
        [
            'name' => 'Outros',
            'image_url' => self::PLACEHOLDER,
        ],
        [
            'name' =>  'ENEM',
            'image_url' => self::PLACEHOLDER,
        ],
        [
            'name' =>  'Encceja',
            'image_url' => self::PLACEHOLDER,
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->categories as $category) {
            Category::create([
                'name' => $category['name'],
                'image_url' => $category['image_url'],
            ]);
        }
    }
}
