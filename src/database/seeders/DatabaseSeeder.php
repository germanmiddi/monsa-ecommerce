<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ContentAboutusTableSeeder::class,
            ContentTableSeeder::class,
            LabelsTableSeeder::class,
            PostCategoriesTableSeeder::class,
            PostStatusesTableSeeder::class,
            OrderStatusTableSeeder::class,
            PagesLegalesTableSeeder::class,
        ]);
       
        
        Role::firstOrCreate([
            'name' => 'admin'
        ]);

        Role::firstOrCreate([
            'name' => 'operator'
        ]);

        Role::firstOrCreate([
            'name' => 'client'
        ]);

        $admin_id = Role::where('name', 'admin')->first()->id;
        
        User::firstOrCreate([
            'email' => 'g@gmail.com'
        ], [
            'name' => 'German Middi',
            'password' => bcrypt('Inicio123'),
            'role_id' => $admin_id
        ]);
       

    }
}
