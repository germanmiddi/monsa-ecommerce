<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            [ 'nombre' => 'Yuasa', 'slug' => 'yuasa', 'orden' => 0,],
            [ 'nombre' => 'AGV', 'slug' => 'agv', 'orden' => 4,],
            [ 'nombre' => 'Metzeler', 'slug' => 'metzeler', 'orden' => 1,],
            [ 'nombre' => 'Did', 'slug' => 'did', 'orden' => 9,],
            [ 'nombre' => 'Horng Fortune', 'slug' => 'horng_fortune', 'orden' => 2,],
            [ 'nombre' => 'Riffel', 'slug' => 'riffel', 'orden' => 3,],
            [ 'nombre' => 'Piton','slug' => 'piton','orden' => 14,],
            [ 'nombre' => 'Kryptonite','slug' => 'kryptonite','orden' => 11,],
            [ 'nombre' => 'Motul','slug' => 'motul','orden' => 12,],
            [ 'nombre' => 'Delta','slug' => 'delta','orden' => 8,],
            [ 'nombre' => 'HFK','slug' => 'hfk','orden' => 10,],
            [ 'nombre' => 'NGK','slug' => 'ngk','orden' => 13,],
            [ 'nombre' => 'Circuit','slug' => 'circuit','orden' => 7,],
            [ 'nombre' => 'Tork','slug' => 'tork','orden' => 15,],
            [ 'nombre' => 'DURO','slug' => 'duro','orden' => 16,],
            [ 'nombre' => 'ProTork','slug' => 'protork','orden' => 6,],
            [ 'nombre' => 'FRAS-LE','slug' => 'fras-le','orden' => 5,],
            [ 'nombre' => 'Fortune','slug' => 'fortune','orden' => 17,],
            [ 'nombre' => 'Driven','slug' => 'driven','orden' => 0,],
            [ 'nombre' => 'Pirelli','slug' => 'pirelli','orden' => 0,],
        ];
        
        DB::table('brand')->insert($brands);        
    }
}
