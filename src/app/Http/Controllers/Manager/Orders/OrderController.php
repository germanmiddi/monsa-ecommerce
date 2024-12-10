<?php

namespace App\Http\Controllers\Manager\Orders;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;
use App\Models\OrderStatus;


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
        $order_status_id = OrderStatus::where('name', 'En Preparación')->first()->id;
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

            // $token = 'eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6IjI4ODRTMUN6aVh2RFctNEh1RnkySyJ9.eyJodHRwczovL25hcmFuamEuY29tL2luZm8iOnsiY2xpZW50SWQiOiJnU3AxVHE0cktrOHFid3lRdXlyYlloeDR1NGMxNlJFOCIsImNsaWVudE5hbWUiOiJCMkJFeHRlcm5hbE1vbnNhU1JMIn0sImlzcyI6Imh0dHBzOi8vbTJtLm5hcmFuamF4LmNvbS8iLCJzdWIiOiJnU3AxVHE0cktrOHFid3lRdXlyYlloeDR1NGMxNlJFOEBjbGllbnRzIiwiYXVkIjoiaHR0cHM6Ly9uYXJhbmphLmNvbS9yYW50eS9tZXJjaGFudHMvYXBpIiwiaWF0IjoxNzMzODE1MzI1LCJleHAiOjE3MzM5MDE3MjUsInNjb3BlIjoid3JpdGUucGF5bWVudF9yZXF1ZXN0IHdyaXRlLmVjb21tZXJjZSB3cml0ZS5pbnRlZ3JhdGlvbiByZWFkLnBheW1lbnQiLCJndHkiOiJjbGllbnQtY3JlZGVudGlhbHMiLCJhenAiOiJnU3AxVHE0cktrOHFid3lRdXlyYlloeDR1NGMxNlJFOCJ9.Sily4sUf3Yej6MLTyTzlAZ3UTlzoQs8XJA68ef2NM1wHCqSpdCO-I5hQj3SMOwY80h_rFRmSRU6ode63Q08D6QQfKZ7j5cSSsLR9QlVdGkqztX_qEd9fOuxKrTNNQm4MoPbrNqcPXT2ZvZg2q4EEb4JSIyurDslZjUpK9yidqTBD79misvdEe1cRe0ZHh2ojLv6ccxz1MqiA6c4ErEy1MqWLzG3Xd-BU3oXAvGiJbcwNs3q-PuW0uZDKnFcb4aS7IcZ4qd5BbWbQpa54UldTmYclkOQ78nPJWP-VYz4T7tAXb1O8fyX94_B3ZNdc5IZRzWdt50otP4lO4phQtE2CcQ';
            $url = env('NAVE_URL_PAYMENT_STATUS');
            $payments = Payment::where('order_id', $order->id)->get();

            if ($payments->isEmpty()) {
                return response()->json(['message' => 'No se encontraron pagos para el pedido'], 404);
            }

            foreach ($payments as $payment) {
                Log::info('Check Payment Status: ' . $order->id . ' - Transaction ID: ' . $payment->transaction_id);

                $get_url = $url . $payment->payment_request_id;

                $http_get = Http::withHeaders([
                                        'Authorization' => 'Bearer ' . $token
                                    ])->get($get_url);

                $response = json_decode($http_get);

                if ($response->status != null) {
                    $payment->update([
                        'status' => $response->status,
                        'payment_check_status' => $response
                    ]);

                    if($response->status == 'SUCCESS_PROCESSED'){
                        $order->update([
                            'payment_status' => 'PAGADO',
                            'order_status_id' => $order_status_id
                        ]);
                    }

                    Log::info('Order: ' . $order->id . ' - Payment:' . $payment->id . ' status updated: ' . $response->status);
                }else{
                    $payment->update([
                        'payment_check_status' => $response
                    ]);
                    Log::error('Error checking payment status: ' . $response->message);
                    return response()->json(['message' => 'Error checking payment status', 'error' => $response->message], 500);
                }
            }
            return response()->json(['message' => 'Payment status updated', 'status' => $response->status], 200);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el estado del pago', 'error' => $e->getMessage()], 500);
        }

    }
}
