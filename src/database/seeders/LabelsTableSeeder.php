<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class LabelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
            'nombre' => 'Carrousel Home',
            'slug' => 'carrousel_home',
            ]
        ];

        foreach ($data as $status) {
            DB::table('labels')->updateOrInsert($status);
        }
    }
}
