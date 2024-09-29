<?php

namespace App\Http\Controllers\Manager\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        return inertia('Manager/Orders/Index');
    }
    
    public function list()
    {
        $result = Order::query();

        $length = request('length');

        if(request('id')){
            $id = request('id');
            $result->where('id',$id);
        }

        if(request('delivery_number')){
            $delivery_number = request('delivery_number');
            $result->where('delivery_number',$delivery_number);
        }

        if(request('cliente')){
            $cliente = request('cliente');
           
            $result->whereHas('client', function ($query) use ($cliente) {
                $query->where('fullname', 'like', "%{$cliente}%");
            });
        }

        if(request('producto')){
            $producto = request('producto');
            $producto= strtoupper($producto);
            $result->whereHas('items', function ($query) use ($producto) {
                $query->whereHas('product', function ($query) use ($producto) {
                    $query->where('sku', $producto)
                          ->orWhere('nombre', 'like', "%{$producto}%");
                });
            });
        }
        
        return $result->with('client', 'items', 'items.product', 'status')
                      ->orderBy('created_at', 'desc')
                      ->paginate($length)
                      ->withQueryString()
                      ->through(fn ($order) => [
                          'id'         => $order->id,
                          'delivery'   => $order->delivery_number,
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

    public function updateStatus(Order $order, Request $request){
        $order->update([
            'order_status_id' => 4,
            'delivery_status' => 'DESPACHADO'
        ]);

        //update stock
        foreach ($order->items as $item) {
            $product = Product::find($item->orderitems_product_id);
            $product->update([
                'stock_reservado' => $product->stock_reservado - $item->quantity,
                'stock_disponible' => $product->stock_disponible - $item->quantity
            ]);
        }

        return response()->json(['message' => 'Status del pedido actualizado'], 200);
    }

}