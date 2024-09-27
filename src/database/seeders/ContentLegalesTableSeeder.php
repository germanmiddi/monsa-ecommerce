<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Content; 

class ContentLegalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $content = [
            [ 'page'    => 'devoluciones', 
              'section' => 'content',
              'element' => 'title',
              'content' => 'Política de Devoluciones y Reembolsos'
            ],
            [ 'page'    => 'devoluciones', 
              'section' => 'content',
              'element' => 'text',
              'content' => ''
            ],

            [ 'page'    => 'envios', 
              'section' => 'content',
              'element' => 'title',
              'content' => 'Política de Envíos'
            ],
            [ 'page'    => 'envios', 
              'section' => 'content',
              'element' => 'text',
              'content' => ''
            ],

            [ 'page'    => 'faq', 
              'section' => 'content',
              'element' => 'title',
              'content' => 'Preguntas Frecuentes'
            ],
            [ 'page'    => 'faq', 
              'section' => 'content',
              'element' => 'text',
              'content' => ''
            ],

            [ 'page'    => 'privacidad', 
              'section' => 'content',
              'element' => 'title',
              'content' => 'Politica de Privacidad y Protección de datos'
            ],
            [ 'page'    => 'privacidad', 
              'section' => 'content',
              'element' => 'text',
              'content' => ''
            ],

            [ 'page'=> 'tyc',
              'section' => 'content',
              'element' => 'title',
              'content' => 'Términos y Condiciones de Uso'
            ],
            [ 'page'=> 'tyc',
              'section' => 'content',
              'element' => 'text',
              'content' => ''
            ],
        ];

        foreach ($content as $data) {
            Content::firstOrCreate($data);
        }
    }
}
