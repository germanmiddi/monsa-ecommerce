<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PagesLegalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'title' => 'Términos y Condiciones',
                'slug' => 'terminos-y-condiciones',
                'content' => '<h1>Términos y Condiciones</h1><p>Contenido de los términos y condiciones...</p>',
            ],
            [
                'title' => 'Política de Privacidad',
                'slug' => 'politica-de-privacidad',
                'content' => '<h1>Política de Privacidad</h1><p>Contenido de la política de privacidad...</p>',
            ],
            [
                'title' => 'Política de Devoluciones y Reembolsos',
                'slug' => 'politica-de-devoluciones-y-reembolsos',
                'content' => '<p>...</p>',
            ],
            [
                'title' => 'Política de Envíos',
                'slug' => 'politica-de-envios',
                'content' => '<p>...</p>',
            ],
            [
                'title' => 'Preguntas Frecuentes',
                'slug' => 'preguntas-frecuentes',
                'content' => '<p>...</p>',
            ],
           
        ];

        foreach ($pages as $page) {
            \App\Models\Page::firstOrCreate(
                ['slug' => $page['slug']],
                $page
            );
        }

    }
}
