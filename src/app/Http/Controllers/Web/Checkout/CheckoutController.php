<?php

namespace App\Http\Controllers\Web\Checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Web\Client\ClientController;
use App\Http\Controllers\Web\Order\OrderController;
use App\Services\DeliveryService;

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
        // Add your logic here
        return  Inertia::render('Web/Checkout/Index');
        
    }

    public function confirmation(Request $request)
    {
        
        // Asumiendo que has obtenido el token de la URL
        $token = $request->token;

        $secretKey = env('SECRET_KEY');
        $cipher = "aes-256-cbc";
        
        // Separar el contenido cifrado del IV
        list($encrypted_data, $iv) = explode(':', $token);
        $iv = base64_decode($iv);

        $order_id = openssl_decrypt($encrypted_data, $cipher, $secretKey, 0, $iv);
        // dd($order_id);

        return  Inertia::render('Web/Checkout/Confirmation',[ 
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

        if(!isset($client->id)){
            return response()->json(['message' => 'Error creating client', 'response' => $client], 500);
        }
        
        $orderController = new OrderController();
        $order = $orderController->store($client->id, $request->totalPrice, $request->cartItems);
        Log::info('Order created: ' . json_encode($order->content()));

        $response = json_decode($order->content());

        if($order->status() != 201){
            return response()->json(['message' => 'Error creating order', 'error' => $response->error ], 500);
        }
                
        $newOrder = $response->order;

        // Crear envío
        $deliveryService = app(DeliveryService::class);
        try {
            $shipment = $deliveryService->createShipment($newOrder, $client, $request->cartItems);
            Log::info('Shipment created: ' . json_encode($shipment));
            // Aquí podrías actualizar la orden con los datos del envío si es necesario
            // $orderController->updateShipmentInfo($newOrder->id, $shipment);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error creating shipment', 'error' => $e->getMessage()], 500);
        }        


        $payment = $this->payment($request, $newOrder->id);
        Log::info('Payment created: ' . json_encode($payment->content()));

        $responsePayment = json_decode($payment->content());

        if($payment->status() != 200){
            return response()->json(['message' => $responsePayment->message, 'error' => $responsePayment->error], 500);
        }

        return response()->json(['message'  => 'Proceso finalizado', 
                                 'payment' => $responsePayment->payment,
                                 'shipment' => $shipment ?? null ]);

    }

    public function payment(Request $request, $order_id)
    {        
        
        $get_token_url = 'https://homoservices.apinaranja.com/security-ms/api/security/auth0/b2b/m2ms';

        $http_token = Http::withHeaders(['Content-Type' => 'application/json'])
                            ->post($get_token_url, 
                                [ 'client_id'     => env('NAVE_CLIENT_ID'),
                                'client_secret' => env('NAVE_CLIENT_SECRET'),
                                'audience'      => "https://naranja.com/ranty/merchants/api" ]);

        if($http_token->status() != 200){
            return response()->json(['message' => 'Error getting token', 'error' => $http_token], 500);
        }

        $response_token = json_decode($http_token);
        $token = $response_token->access_token;

        $url    = 'https://e3-api.ranty.io/ecommerce/payment_request/external';

        $params = $this->_buildPaymentData($request->all(), $order_id);

        Log::info('Payment data: ' . json_encode($params));
        $http_post = Http::withHeaders([ 'Authorization' => 'Bearer ' . $token,
                                         'Content-Type'  => 'application/json'])
                           ->post($url, $params);
        
        if($http_post->status() != 200){
            return response()->json(['message' => 'Error creating payment method', 'error' => $http_token], 500);
        }

        $response = json_decode($http_post);
        
        return response()->json(['message' => 'Payment created successfully', 'payment' => $response], 200);
        
                         
    }
    
    private function _buildPaymentData($request, $order_id)
    {

        $items = $this->_generateItems($request['cartItems']);
        $callback_url = $this->_generateCallbackUrl($order_id);

        $total = array_reduce($items, function($carry, $item) {
            return $carry + $item['unit_price']['value'];
        }, 0);
        $total = number_format($total, 2, '.', '');


        return [
                    "store_id" => "YqzLxzVobkr6Xqk7JGZmzZsHqmTOAL37",
                    "platform" => "monsa_srl",
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

    public function _generateItems($cartItems){

        $items = array_map(function($i){
            return[
                // "id" => $i['_id'],
                "id" => "883627",
                "name" => $i['nombre'],
                "description" => $i['modelo'],
                "quantity"    => 1,
                "unit_price"  => [
                    "currency" => "ARS",
                    "value"    => $i['price_public'] . ".00"
                    // "value"    => "299.00"
                ]
            ];
        }, $cartItems);
        
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

    // private function _buildDeliveryRequestData($request)
    // {
    //     $items = array_map(function($item) {
    //         return [
    //             "sku" => $item['sku'],
    //             "weight" => $item['peso'] == 0 ? 10 : $item['peso'],
    //             "height" => $item['alto'] == 0 ? 10 : $item['alto'],
    //             "width" => $item['ancho'] == 0 ? 10 : $item['ancho'],
    //             "length" => $item['largo'] == 0 ? 10 : $item['largo'],
    //             "description" => $item['nombre'],
    //             "classification_id" => 1 //$item['classification_id']
    //         ];
    //     }, $request['items']);
        
    //     return [
    //         "account_id" => "12222",
    //         "origin_id" => "345752",
    //         "declared_value" => $request['total'],
    //         "items" => $items,
    //         "destination" => [
    //             "city" => $request['city'],
    //             "state" => $request['state'],
    //             "zipcode" => $request['zip']
    //         ]
    //     ];
    // }
    
    // public function calcDelivery(Request $request)
    // {

    //     // Construir los datos de la solicitud
    //     $requestData = $this->_buildDeliveryRequestData($request->form);

    //     // Username y Password de la autenticación básica
    //     $username = env('ZIPPIN_API_KEY'); 
    //     $password = env('ZIPPIN_API_SECRET');
    
    //     // Hacer la solicitud a la API externa
    //     $response = Http::withBasicAuth($username, $password)
    //                     ->withHeaders([
    //                         'Accept' => 'application/json',
    //                         'Content-Type' => 'application/json'
    //                     ])->post('https://api.zippin.com.ar/v2/shipments/quote', $requestData);

    
    //     // Verificar si la solicitud fue exitosa
    //     if ($response->successful()) {
    //         $data = $response->json();
    //         $price = $data['results']['standard_delivery']['amounts']['price_incl_tax'];

    //         return response()->json(['message' => 'Delivery calculated successfully', 
    //                                  'data'    => $data['results'],
    //                                  'price'   => $price,
    //                                  'carrier' => $data['results']['standard_delivery']['carrier']
    //                             ], 200);
    //     } else {
    //         return response()->json(['message' => 'Error calculating delivery', 'error' => $response->body()], $response->status());
    //     }
    // }

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
