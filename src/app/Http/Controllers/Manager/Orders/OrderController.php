<?php

namespace App\Http\Controllers\Manager\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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

        if (request('id')) {
            $id = request('id');
            $result->where('id', $id);
        }

        if (request('delivery_number')) {
            $delivery_number = request('delivery_number');
            $result->where('delivery_number', $delivery_number);
        }

        if (request('cliente')) {
            $cliente = request('cliente');

            $result->whereHas('client', function ($query) use ($cliente) {
                $query->where('fullname', 'like', "%{$cliente}%");
            });
        }

        if (request('producto')) {
            $producto = request('producto');
            $producto = strtoupper($producto);
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
            ->through(fn($order) => [
                'id' => $order->id,
                'delivery' => $order->delivery_number,
                'client' => $order->client,
                'items' => $order->items,
                'status' => $order->status,
                'total' => $order->total,
                'created_at' => $order->created_at->format('d/m/Y'),
            ]);
    }

    public function detail(Order $order)
    {
        return inertia('Manager/Orders/Detail', [
            'order' => $order->load('client', 'items', 'items.product', 'status', 'shipments'),
            'subtotal' => $order->items->sum(fn($item) => $item->total),
        ]);
    }

    public function updateStatus(Order $order, Request $request)
    {
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

    public function requestPaymentStatus(Order $order)
    {

        try {

            $get_token_url = env('NAVE_URL');

            $payload = [
                'client_id' => env('NAVE_CLIENT_ID'),
                'client_secret' => env('NAVE_CLIENT_SECRET'),
                'audience' => "https://naranja.com/ranty/merchants/api"
            ];

            $http_token = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post($get_token_url, $payload);

            if ($http_token->status() != 200) {
                // Registrar detalles de la solicitud y respuesta
                Log::error('Error obteniendo token', [
                    'url' => $get_token_url,
                    'headers' => ['Content-Type' => 'application/json'],
                    'payload' => $payload,
                    'response_status' => $http_token->status(),
                    'response_body' => $http_token->body(),
                    'response_headers' => $http_token->headers(),
                ]);

                return response()->json(['message' => 'Error getting token', 'error' => $http_token->body()], 500);
            }

            $response_token = json_decode($http_token);
            Log::info('Token obtenido: ' . $response_token->access_token);
            $token = $response_token->access_token;

            $url = env('NAVE_URL_PAYMENT_STATUS');
            $payments = $order::with('payments')->get();

            if ($payments->isEmpty()) {
                return response()->json(['message' => 'No se encontraron pagos para el pedido'], 404);
            }

            foreach ($payments as $payment) {
                Log::info('Check Payment Status: ' . $order->id . ' - Transaction ID: ' . $payment->transaction_id);

                $http_get = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token,
                    'Content-Type' => 'application/json'
                ])->get($url . $payment->transaction_id);

                dd($http_get);
                $response = json_decode($http_get);
                if ($response->message) {
                    Log::error('Error checking payment status: ' . $response->message);
                    return response()->json(['message' => 'Error checking payment status', 'error' => $response->message], 500);
                }

                $payment->update([
                    'payment_status' => $response->status
                ]);

            }

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el estado del pago', 'error' => $e->getMessage()], 500);
        }

    }
}
