<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
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
                'module' => 'import',
                'key' => 'last_import_product',
                'value' => '2024-01-01',
            ],
            [
                'module' => 'import',
                'key' => 'last_import_families',
                'value' => '2024-01-01',
            ],
            [
                'module' => 'import',
                'key' => 'last_import_brand',
                'value' => '2024-01-01',
            ],
            [
                'module' => 'import',
                'key' => 'last_import_attributes',
                'value' => '2024-01-01',
            ],

        ];
        
        foreach ($data as $setting) {
            DB::table('settings')->insert($setting);
        }
        
    }
}
