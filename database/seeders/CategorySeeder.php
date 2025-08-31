<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1) Categorías base
        $categorias = ['Sandalia','Tacón','Casual','Confort'];
        foreach ($categorias as $catName) {
            Category::updateOrCreate(
                ['nombre' => $catName],
                ['slug' => Str::slug($catName)]
            );
        }
    }
}
