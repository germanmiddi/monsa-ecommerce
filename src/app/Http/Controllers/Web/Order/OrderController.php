<?php

namespace App\Http\Controllers\Web\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipment;
use App\Models\Product;

class OrderController extends Controller
{
    // Controller methods go here
    public function store($client_id, $totalPrice, $cartItems)
    {
        DB::beginTransaction();
        try {

            $order = Order::create(attributes: [
                'order_status_id'      => 3,
                'order_client_id'      => $client_id,
                'payment_status'       => 'PENDING',
                'subtotal'             => array_sum(array_column($cartItems, 'sale_price')),
                'total'                => $totalPrice                
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'orderitems_order_id'   => $order->id,
                    'orderitems_product_id' => $item['id'],
                    'quantity'   => 1, //$item['quantity'],
                    'price'      => $item['sale_price'],
                    'total'      => $item['sale_price']
                ]);

                $product = Product::find($item['id']);
                $product->update([
                    'stock_reservado' => $product->stock_reservado + 1
                ]);

            }

            DB::commit();
            // return $order;
            return response()->json(['message' => 'Order created successfully', 'order' => $order->toArray()], 201);
            
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error creating order', 'error' => $e->getMessage()], 500);
            // return $e->getMessage();
        }
    }

    public function update($orderId, $shipmentId)
    {   
        try{
            DB::beginTransaction();

            $order = Order::findOrFail($orderId);
            $shipment = Shipment::findOrFail($shipmentId);            
            
            $order->update([
                'delivery_number'      => $shipment->delivery_id,
                'delivery_traking_number' => $shipment->tracking_number,
                'delivery_status'      => $shipment->status_name,
                'delivery_amount'      => $shipment->price_incl_tax
            ]);
            DB::commit();
            return response()->json(['message' => 'Order updated successfully', 'order' => $order->load('items', 'items.product')], 200);

        }catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => 'Error updating order', 'error' => $e->getMessage()], 500);
        }
    }
    
    public function viewDetail(Request $request)
    {
        
        $orderId = $request->orderId;
        
        try{
            $order = Order::where('id', $orderId)->with(['items', 'items.product', 'shipments', 'client'])->first();
                          
            // Add your logic here
            return  Inertia::render('Web/Order/SingleDetails', [
                'order' => $order
            ]);
        }catch (\Exception $e) {
            //render error page
            return Inertia::render('Web/Error', [
                'error' => $e->getMessage()
            ]);
        }
    }
}

