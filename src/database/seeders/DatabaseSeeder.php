<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        
        User::firstOrCreate([
            'email' => 'g@gmail.com'
        ], [
            'name' => 'German Middi',
            'password' => bcrypt('Inicio123')
        ]);
       

    }
}
