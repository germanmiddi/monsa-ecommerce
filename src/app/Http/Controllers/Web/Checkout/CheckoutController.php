<?php

namespace App\Http\Controllers\Web\Checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use App\Mail\OrderConfirmation;
use App\Http\Controllers\Web\Client\ClientController;
use App\Http\Controllers\Web\Order\OrderController;
use App\Services\DeliveryService;
use App\Services\PaymentService;

use App\Models\Order;

class CheckoutController extends Controller
{
    /**
     * Display the home page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if (env('SHOW_MODULE_STORE', false) === false) {
            abort(404); // O redirige a otra ruta, por ejemplo: return redirect()->route('home');
        }

        // Add your logic here
        return Inertia::render('Web/Checkout/Index');

    }

    public function confirmation(Request $request)
    {

        $token = $request->token;

        $secretKey = env('SECRET_KEY');
        $cipher = "aes-256-cbc";

        // Separar el contenido cifrado del IV
        list($encrypted_data, $iv) = explode(':', $token);
        $iv = base64_decode($iv);

        $order_id = openssl_decrypt($encrypted_data, $cipher, $secretKey, 0, $iv);

        return Inertia::render('Web/Checkout/Confirmation', [
            'order' => Order::where('id', $order_id)
                ->with('items', 'client', 'items.product')
                ->first()
                ->toArray()
        ]);

    }

    //fix the payment method to receive the request

    public function process(Request $request)
    {

        $clientController = new ClientController();
        $client = $clientController->store($request->customerDetails);
        Log::info('Client created: ' . json_encode($client));

        if (!isset($client->id)) {
            return response()->json(['message' => 'Error creating client', 'response' => $client], 500);
        }
        if (!$request->cart_id) {
            return response()->json(['message' => 'Error creating order', 'error' => 'Cart id is required'], 500);
        }

        $orderController = new OrderController();
        $order = $orderController->store($client->id, $request->cart_id, $request->totalPrice, $request->cartItems);
        Log::info('Order created: ' . json_encode($order->content()));

        $response = json_decode($order->content());

        if ($order->status() != 201) {
            return response()->json(['message' => 'Error creating order', 'error' => $response->error], 500);
        }

        $newOrder = $response->order;

        // Crear envío
        if ($request->customerDetails['zip'] != '0000') {
            $deliveryService = app(DeliveryService::class);
            try {
                //Se crea el envio
                $shipment = $deliveryService->createShipment($newOrder, $client, $request->cartItems);
                Log::info('Shipment created: ' . json_encode($shipment));

                //Se actualiza la orden con la info del envio
                $order = $orderController->update($newOrder->id, $shipment->id);
                $response = json_decode($order->content());
                $newOrder = $response->order;

            } catch (\Exception $e) {
                return response()->json(['message' => 'Error al crear el envío', 'error' => $e->getMessage()], 500);
            }
        } else {
            $newOrder->delivery_amount = "1.00";
        }

        $payment = $this->payment($request, $newOrder->id, $newOrder->delivery_amount);
        Log::info('Payment created: ' . json_encode($payment->content()));

        $paymentService = app(PaymentService::class);
        $response_storepayment = $paymentService->store($newOrder->id, $payment->content());
        $responsePayment = json_decode($payment->content());

        if ($payment->status() != 200) {
            return response()->json(['message' => $responsePayment->message, 'error' => $responsePayment->error], 500);
        }

        if ($payment->status() == 200) {
            // Envía el correo electrónico de confirmación
            Mail::to($client->email)->send(new OrderConfirmation($newOrder, $client, $shipment ?? null));
        }

        //Se actualiza el estado de la orden una vez que se ha creado el pago y el envío
        $updateStatus = $orderController->updateStatus($newOrder->id, 3);

        return response()->json([
            'message' => 'Proceso finalizado',
            'payment' => $responsePayment->payment,
            'shipment' => $shipment ?? null
        ]);

    }

    public function payment(Request $request, $order_id, $delivery_amount)
    {
        //Get Token Nave
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

        //Crear Intencion de Pago
        $url = env('NAVE_URL_PAYMENT');

        $params = $this->_buildPaymentData($request->all(), $order_id, $delivery_amount);

        Log::info('Payment data: ' . json_encode($params));
        $http_post = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json'
        ])
            ->post($url, $params);


        if ($http_post->status() != 200) {
            Log::error('Error creating payment method: ' . json_encode($http_post->body()));
            return response()->json(['message' => 'Error creando el metodo de pago', 'error' => $http_post->body()], 500);
        }

        $response = json_decode($http_post);
        Log::info('Payment created successfully: ' . json_encode($response));
        return response()->json(['message' => 'Payment created successfully', 'payment' => $response], 200);


    }

    private function _buildPaymentData($request, $order_id, $delivery_amount)
    {

        $items = $this->_generateItems($request['cartItems'], $delivery_amount);
        $callback_url = $this->_generateCallbackUrl($order_id);
        $total = number_format($request['totalPrice'], 2, '.', '');

        $platform = env('NAVE_PLATFORM');
        $store_id = env('NAVE_STORE_ID');

        return [
            "store_id" => $store_id,
            "platform" => $platform,
            "callback_url" => $callback_url,
            "order_id" => $order_id,
            "mobile" => false,
            "payment_request" => [
                "transactions" => [
                    [
                        "products" => $items,
                        "amount" =>
                            [
                                "currency" => "ARS",
                                "value" => $total
                            ]
                    ]
                ],
                "buyer" =>
                    [
                        "user_id" => $request['customerDetails']['email'],
                        "doc_type" => "DNI",
                        "doc_number" => "N/A",
                        "user_email" => $request['customerDetails']['email'],
                        "name" => "N/A",
                        "phone" => "N/A",
                        "billing_address" =>
                            [
                                "street_1" => $request['customerDetails']['address'],
                                "street_2" => "N/A",
                                "city" => "1",
                                "region" => "Buenos Aires",
                                "country" => "AR",
                                "zipcode" => "1234"
                            ]
                    ]
            ]
        ];

    }

    public function _generateItems($cartItems, $delivery_amount)
    {

        $items = array_map(function ($i) {
            return [
                // "id" => $i['_id'],
                "id" => "883627",
                "name" => $i['nombre'],
                "description" => $i['modelo'],
                "quantity" => 1,
                "unit_price" => [
                    "currency" => "ARS",
                    "value" => $i['sale_price'] . ".00"
                    // "value"    => "299.00"
                ]
            ];
        }, $cartItems);

        $items = array_merge($items, [
            [
                "id" => "883628",
                "name" => "Envío",
                "description" => "Envío a domicilio",
                "quantity" => 1,
                "unit_price" => [
                    "currency" => "ARS",
                    "value" => $delivery_amount
                ]
            ]
        ]);

        return $items;
    }

    public function _generateCallbackUrl($order_id)
    {
        $base_url = env('BASE_URL');

        $secretKey = env('SECRET_KEY');
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

        // Cifrar el order_id
        $order_id = $order_id; // El order_id que quieres cifrar
        $cipher = "aes-256-cbc";
        $encrypted = openssl_encrypt($order_id, $cipher, $secretKey, 0, $iv);
        $encrypted = $encrypted . ':' . base64_encode($iv); // Concatenar IV al mensaje cifrado porque se necesitará para descifrar

        // Tokenizado para enviar en URL
        $token = urlencode($encrypted);

        $callback_url = $base_url . "checkout/confirmation?token={$token}";

        return $callback_url;

    }

    public function calcDelivery(Request $request)
    {
        // Inyectamos el DeliveryService solo cuando lo necesitamos
        $deliveryService = app(DeliveryService::class);

        try {
            $result = $deliveryService->calculateDelivery($request->form);
            return response()->json($result, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }

}
