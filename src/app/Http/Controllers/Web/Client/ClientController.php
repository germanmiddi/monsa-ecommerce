<?php

namespace App\Http\Controllers\Web\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\Models\Client;

class ClientController extends Controller
{
    public function store($data)
    {
        DB::beginTransaction();
        try {
            $client = Client::firstOrCreate([
                'email' => $data['email']
            ], [
                'fullname'  => $data['fullname'],
                'cellphone' => $data['cellphone'],
                'address'   => $data['address'] . ' ' . $data['addressNro'],
                'city'      => $data['city'],
                'state'     => $data['state'],
                'zip'       => $data['zip']
            ]);

            DB::commit();
            return $client;

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }        
    }
}
