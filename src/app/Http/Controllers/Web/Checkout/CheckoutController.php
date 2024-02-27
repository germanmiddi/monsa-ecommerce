<?php

namespace App\Http\Controllers\Web\Checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Web\Client\ClientController;
use App\Http\Controllers\Web\Order\OrderController;

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
        // Add your logic here
        return  Inertia::render('Web/Checkout/Confirmation');
        
    }

    //fix the payment method to receive the request

    public function process(Request $request)
    {

        $clientController = new ClientController();
        $client = $clientController->store($request->customerDetails);

        if(!$client){
            return response()->json(['message' => 'Error creating client'], 500);
        }
        
        $orderController = new OrderController();
        $order = $orderController->store($client->id, $request->totalPrice, $request->cartItems);

        if(!$order){
            return response()->json(['message' => 'Error creating order'], 500);
        }

        $payment = $this->payment($request);

        return response()->json(['message'  => 'Payment processed', 
                                 'response' => $payment ]);

    }

    public function payment(Request $request)
    {        
        
        $params = $this->_buildPaymentData($request->all());
        // dd($params);

        $get_token_url = 'https://homoservices.apinaranja.com/security-ms/api/security/auth0/b2b/m2ms';

        $http_token = Http::post($get_token_url, 
                                [ 'client_id'     => "YqzLxzVobkr6Xqk7JGZmzZsHqmTOAL37",
                                  'client_secret' => "jB8SQ3rfrvnn9JeeLktg3YQ6yWyp-Vzl7nxtUJE50TthNAKwOdl1lV1X4d7hVOoZ",
                                  'audience'      => "https://naranja.com/ranty/merchants/api" ]);
                                
        
        $token = json_decode($http_token)->access_token;

        // dd($token);
        $url    = 'https://e3-api.ranty.io/ecommerce/payment_request/external';

        $params = $this->_buildPaymentData($request->all());
        
        $http_post = Http::withHeaders([ 'Authorization' => 'Bearer ' . $token,
                                         'Content-Type'  => 'application/json'])
                           ->post($url, $params);

        $response = json_decode($http_post);
        
        return $response;
                         
    }
    
    private function _buildPaymentData($request)
    {
        // dd($request);
        $cartItems = $request['cartItems'];


        $items = array_map(function($i){
            return[
                // "id" => $i['_id'],
                "id" => "883627",
                "name" => $i['nombre'],
                "description" => $i['modelo'],
                "quantity"    => 1,
                "unit_price"  => [
                    "currency" => "ARS",
                    "value"    => $i['precio']
                    // "value"    => "299.00"
                ]
            ];
        }, $cartItems);

        // $items = [
        //             [
        //                 "id" => "883627",
        //                 "name" => "Café con Leche",
        //                 "description" => "Café con Leche",
        //                 "quantity" => 2,
        //                 "unit_price" => [
        //                     "currency" => "ARS",
        //                     "value" => "299.00"
        //                 ]
        //             ]
        //         ];        

        // dd($otro, $items);

        return [
                    "store_id" => "YqzLxzVobkr6Xqk7JGZmzZsHqmTOAL37",
                    "platform" => "monsa_srl",
                    "callback_url" => "https://www.monsasrl.com.ar/view/result/order/9546", // Corregido aquí
                    "order_id" => 100310692,
                    "mobile" => false,
                    "payment_request" => [
                        "transactions" => [
                            [
                                "products" => $items,
                                // "products" =>   [
                                //                     [
                                //                         "id" => "883627",
                                //                         "name" => "Café con Leche",
                                //                         "description" => "Café con Leche",
                                //                         "quantity" => 2,
                                //                         "unit_price" => [
                                //                             "currency" => "ARS",
                                //                             "value" => "299.00"
                                //                         ]
                                //                     ]
                                //                 ],
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
                                        // "region" => $request['customerDetails']['state'],
                                        "region" => "Buenos Aires",
                                        "country" => "AR",
                                        "zipcode" => "1234"
                                    ]
                            ]
                        ]
                ];

    }
    // Add more methods as needed
}
