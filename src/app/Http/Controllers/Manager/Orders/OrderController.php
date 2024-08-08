<?php

namespace App\Http\Controllers\Manager\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return inertia('Manager/Orders/Index');
    }
    
    public function list()
    {

        $result = Order::query();

        return $result->with('client', 'items', 'items.product', 'status')
                      ->orderBy('created_at', 'desc')
                      ->paginate(20)
                      ->withQueryString()
                      ->through(fn ($order) => [
                          'id'         => $order->id,
                          'client'     => $order->client,
                          'items'      => $order->items,
                          'status'     => $order->status,
                          'total'      => $order->total,
                          'created_at' => $order->created_at->format('d/m/Y'),]);
    }

    public function detail(Order $order)
    {
        return inertia('Manager/Orders/Detail', [
            'order' => $order->load('client', 'items', 'items.product', 'status', 'shipments'),
            'subtotal' => $order->items->sum(fn ($item) => $item->total),
        ]);
    }
}