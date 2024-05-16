<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
            'name' => 'Novedades',
            'slug' => Str::slug('novedades'),
            'description' => null,
            'image' => null,
            'parent_id' => null,
            'order' => null,
            'featured' => false,
            'menu' => false,
            'active' => true,
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Lanzamiento',
            'slug' => Str::slug('Lanzamiento'),
            'description' => null,
            'image' => null,
            'parent_id' => null,
            'order' => null,
            'featured' => false,
            'menu' => false,
            'active' => true,
            'created_at' => now(),
            'updated_at' => now(),
            ],
            [
            'name' => 'Nuevo Ingreso',
            'slug' => Str::slug('Nuevo Ingreso'),
            'description' => null,
            'image' => null,
            'parent_id' => null,
            'order' => null,
            'featured' => false,
            'menu' => false,
            'active' => true,
            'created_at' => now(),
            'updated_at' => now(),
            ],
        ];

        foreach ($categories as $category) {
            DB::table('post_categories')->updateOrInsert(
            ['name' => $category['name']],
            $category
            );
        }
        ]);
    }
}
