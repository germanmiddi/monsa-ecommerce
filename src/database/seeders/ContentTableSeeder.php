<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $content = [
            [   
                'page' => 'home',
                'section' => 'banner',
                'element' => 'h1',
                'content' => '',
            ],
            [   
                'page' => 'home',
                'section' => 'banner',
                'element' => 'h2',
                'content' => '',
            ],
            [   
                'page' => 'home',
                'section' => 'banner',
                'element' => 'link',
                'content' => '',
            ],
            [   
                'page' => 'home',
                'section' => 'banner',
                'element' => 'image',
                'content' => '',
            ],
            [   
                'page' => 'home',
                'section' => 'banner',
                'element' => 'image',
                'content' => '',
            ],
            [   
                'page' => 'home',
                'section' => 'banner',
                'element' => 'image',
                'content' => '',
            ],
            [   
                'page' => 'home',
                'section' => 'banner',
                'element' => 'image',
                'content' => '',
            ],
        ];

        foreach ($content as $data) {
            DB::table('contents')->firstOrCreate($data);
        }
    }
}
