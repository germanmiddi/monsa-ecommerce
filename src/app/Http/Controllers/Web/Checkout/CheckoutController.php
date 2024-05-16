<?php

namespace App\Http\Controllers\Web\Checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Web\Client\ClientController;
use App\Http\Controllers\Web\Order\OrderController;

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

        if(!isset($client->id)){
            return response()->json(['message' => 'Error creating client', 'response' => $client], 500);
        }
        
        $orderController = new OrderController();
        $order = $orderController->store($client->id, $request->totalPrice, $request->cartItems);
        
        $response = json_decode($order->content());

        if($order->status() != 201){
            return response()->json(['message' => 'Error creating order', 'error' => $response->error ], 500);
        }
                
        $newOrder = $response->order;

        $payment = $this->payment($request, $newOrder->id);

        return response()->json(['message'  => 'Proceso finalizado', 
                                 'response' => $payment ]);

    }

    public function payment(Request $request, $order_id)
    {        
        
        $get_token_url = 'https://homoservices.apinaranja.com/security-ms/api/security/auth0/b2b/m2ms';

        $http_token = Http::post($get_token_url, 
                                [ 'client_id'     => env('NAVE_CLIENT_ID'),
                                  'client_secret' => env('NAVE_CLIENT_SECRET'),
                                  'audience'      => "https://naranja.com/ranty/merchants/api" ]);
                                
        if($http_token->status() != 200){
            return response()->json(['message' => 'Error getting token', 'response' => $http_token], 500);
        }

        $response_token = json_decode($http_token);
        $token = $response_token->access_token;

        $url    = 'https://e3-api.ranty.io/ecommerce/payment_request/external';

        $params = $this->_buildPaymentData($request->all(), $order_id);
        
        $http_post = Http::withHeaders([ 'Authorization' => 'Bearer ' . $token,
                                         'Content-Type'  => 'application/json'])
                           ->post($url, $params);
        
        if($http_post->status() != 200){
            return response()->json(['message' => 'Error getting token', 'response' => $http_token], 500);
        }

        $response = json_decode($http_post);
        
        return $response;
                         
    }
    
    private function _buildPaymentData($request, $order_id)
    {

        $items = $this->_generateItems($request['cartItems']);
        $callback_url = $this->_generateCallbackUrl($order_id);

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
                                    "value" => "498.00"
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
                    "value"    => $i['precio'] . ".00"
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
}
