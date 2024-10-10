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
            [
                'module' => 'contact',
                'key' => 'email',
                'value' => 'info@example.com',
            ],            
            [
                'module' => 'contact',
                'key' => 'phone',
                'value' => '1234567890',
            ],            
            [
                'module' => 'contact',
                'key' => 'whatsapp',
                'value' => '1234567890',
            ],            
            [
                'module' => 'contact',
                'key' => 'instagram',
                'value' => 'https://www.instagram.com/example',
            ],      
            [
                'module' => 'contact',
                'key' => 'facebook',
                'value' => 'https://www.facebook.com/example',
            ],      
            [
                'module' => 'main',
                'key' => 'code-head',
                'value' => '<script></script>',
            ],
            [
                'module' => 'main',
                'key' => 'code-body',
                'value' => '<script></script>',
            ],


        ];
        
        foreach ($data as $setting) {
           $settingLocal = DB::table('settings')->where('key', $setting['key'])->first();    
           if ($settingLocal) {
                continue;
           } else {
                DB::table('settings')->insert($setting);
           }
        }
        
    }
}
