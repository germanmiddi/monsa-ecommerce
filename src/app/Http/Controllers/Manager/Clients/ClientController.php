<?php

namespace App\Http\Controllers\Manager\Clients;

use App\Http\Controllers\Controller;
use App\Models\Client;

class ClientController extends Controller
{
    public function index()
    {
        return inertia('Manager/Clients/Index');
    }
    public function list()
    {
        $result = Client::query();

        return $result->with('orders')
                      ->orderBy('created_at', 'desc')
                      ->paginate(20)
                      ->withQueryString();
    }
}