<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PostStatusesTableSeeder extends Seeder
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
            'name' => 'Borrador',
            ],
            [
            'name' => 'Publicado',
            ]
        ];

        foreach ($data as $status) {
            DB::table('post_statuses')->updateOrInsert($status);
        }
    }
}
