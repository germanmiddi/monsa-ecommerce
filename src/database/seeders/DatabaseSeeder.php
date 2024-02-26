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
         
        // $this->call(FamilyTableSeeder::class);
        // $this->call(BrandTableSeeder::class);
        // $this->call(AtributeTableSeeder::class);
        $this->call([
            FamilyTableSeeder::class,
            BrandTableSeeder::class,
            AtributeTableSeeder::class,
            ProductTableSeeder::class,
            PostCategoriesTableSeeder::class,
            PostStatusesTableSeeder::class,
        ]);
        
        

        

        // User::create([
        //     'name' => 'German Middi',
        //     'email' => 'g@gmail.com',
        //     'password' => bcrypt('Inicio123')
        // ]);
       

    }
}
