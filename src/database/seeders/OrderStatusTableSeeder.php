<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            [
                'id' => 1,
                'name' =>	'Pendiente de pago',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [ 'id' => 2,
                'name' => 'En espera',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 3,
                'name' => 'En Preparación',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Completado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'name' => 'Cancelado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'name' => 'Fallido',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'name' => 'Reembolsado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($status as $st) {
            DB::table('order_statuses')
                ->updateOrInsert(['id' => $st['id']],$st);
        }
    }    
    
}
