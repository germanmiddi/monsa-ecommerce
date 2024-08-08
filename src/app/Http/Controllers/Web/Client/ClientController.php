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
            $client = Client::updateOrCreate([
                'email' => $data['email']
            ], [
                'fullname'   => $data['fullname'],
                'cellphone'  => $data['cellphone'],
                'address'    => $data['address'],
                'city'       => $data['city'],
                'state'      => $data['state'],
                'zip'        => $data['zip'],
                'document'   => $data['document'],
                'street_num' => $data['addressNro'],
                'street_extras' => $data['addressExtras'],
                'cuit'       => $data['cuit'],
            ]);

            DB::commit();
            return $client;

        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }        
    }
}
