<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Content; // Asegúrate de usar el namespace correcto para tu modelo

class ContentTableSeeder extends Seeder
{
    public function run()
    {
        $content = [
            ['page' => 'home', 'section' => 'banner', 'element' => 'h1', 'content' => ''],
            ['page' => 'home', 'section' => 'banner', 'element' => 'h2', 'content' => ''],
            ['page' => 'home', 'section' => 'banner', 'element' => 'link', 'content' => ''],
        ];

        foreach ($content as $data) {
            Content::firstOrCreate($data);
        }
    }
}
