<?php

namespace App\Http\Controllers\Web\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    // Controller methods go here
    public function store($client_id, $totalPrice, $cartItems)
    {
        DB::beginTransaction();
        try {

            $order = Order::create([
                // 'order_user_id'        =>
                'order_status_id'      => 1,
                'order_client_id'      => $client_id,
                // 'payment_order_number' => '',
                'payment_status'       => 'pending',
                // 'delivery_number'      =>
                // 'delivery_traking_number' =>
                // 'delivery_status'      =>
                // 'delivery_amount'      =>
                'total'                => $totalPrice                
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'orderitems_order_id'   => $order->id,
                    'orderitems_product_id' => $item['id'],
                    'quantity'   => 1, //$item['quantity'],
                    'price'      => $item['precio'],
                    'total'      => $item['precio']
                ]);
            }

            DB::commit();
            return $order;
            
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }
    }

}

