<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Content; // Asegúrate de usar el namespace correcto para tu modelo

class ContentAboutusTableSeeder extends Seeder
{
    public function run()
    {
        $content = [
            ['page' => 'aboutus', 'section' => 'content', 'element' => 'text', 'content' => ''],
            ['page' => 'aboutus', 'section' => 'content', 'element' => 'img', 'content' => ''],
        ];

        foreach ($content as $data) {
            Content::firstOrCreate($data);
        }
    }
}
