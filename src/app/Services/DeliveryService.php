<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use App\Models\Client;
use App\Models\Shipment;

class DeliveryService
{
    private $apiKey;
    private $apiSecret;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('ZIPPIN_API_KEY');
        $this->apiSecret = env('ZIPPIN_API_SECRET');
        $this->baseUrl = 'https://api.zippin.com.ar/v2';
    }

    public function calculateDelivery(array $form)
    {
        $requestData = $this->buildCalcDeliveryRequestData($form);

        $response = $this->makeApiCall('post', '/shipments/quote', $requestData);

        if ($response->successful()) {
            $data = $response->json();
            $price = $data['results']['standard_delivery']['amounts']['price_incl_tax'];

            return [
                'message' => 'Delivery calculated successfully',
                'data' => $data['results'],
                'price' => $price,
                'carrier' => $data['results']['standard_delivery']['carrier']
            ];
        } else {
            throw new \Exception('Error calculating delivery: ' . $response->body(), $response->status());
        }
    }

    public function createShipment($order, Client $client, $cartItems)
    {
        // dd($order, $client, $cartItems);
        $data = $this->prepareShipmentData($order, $client, $cartItems);
        Log::info('Shipment data: ' . json_encode($data));
        $response = $this->makeApiCall('post', '/shipments', $data);

        if ($response->successful()) {
            $shipmentData = $response->json();
            // Almacenar el envío en la base de datos
            $shipment = $this->storeShipment($order, $shipmentData);            
            return $shipment;
        } else {
            throw new \Exception('Error creating shipment: ' . $response->body(), $response->status());
        }
    }

    private function makeApiCall($method, $endpoint, $data = [])
    {
        return Http::withBasicAuth($this->apiKey, $this->apiSecret)
            ->withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])
            ->$method($this->baseUrl . $endpoint, $data);
    }

    private function buildCalcDeliveryRequestData(array $form)
    {
        $items = array_map(function($item) {
            return [
                "sku" => $item['sku'],
                "weight" => $item['peso'] == 0 ? 10 : $item['peso'],
                "height" => $item['alto'] == 0 ? 10 : $item['alto'],
                "width" => $item['ancho'] == 0 ? 10 : $item['ancho'],
                "length" => $item['largo'] == 0 ? 10 : $item['largo'],
                "description" => $item['nombre'],
                "classification_id" => 1
            ];
        }, $form['items']);
        
        return [
            "account_id" => "12222",
            "origin_id" => "345752",
            "declared_value" => $form['total'],
            "items" => $items,
            "destination" => [
                "city" => $form['city'],
                "state" => $form['state'],
                "zipcode" => $form['zip']
            ]
        ];
    }

    private function prepareShipmentData($order, Client $client, $cartItems)
    {

        return [
            'account_id' => env('ZIPPIN_ACCOUNT_ID'),
            'origin_id'  => env('ZIPPIN_ORIGIN_ID'),
            'declared_value' => $order->total,
            'external_id' => $order->id,
            'destination' => [
                'name' => $client->fullname,
                'email' => $client->email,
                'phone' => $client->cellphone,
                'street' => $client->address ?? null,
                'street_number' => $client->street_num ?? null,
                'street_extras' => $client->street_extras ?? null,
                // 'point_id' => $client->point_id ?? null,
                'document' => $client->document ?? null,
                'state' => $client->state ?? null,
                'city' => $client->city ?? null,
                'zipcode' => $client->zip?? null,
                'country' => $client->country ?? 'AR',
            ],
            'items' => array_map(function($item) {
                return [
                    'sku' => $item['sku'] ?? null,
                    'weight' => 10,
                    'height' => 10,
                    'width'  => 10,
                    'length' => 10,
                    'description' => $item['nombre'] ?? null,
                    'classification_id' => $item['classification_id'] ?? 1,
                ];
            }, $cartItems),
            'logistic_type' => 'crossdock', 
            'service_type' => 'standard_delivery',
            'carrier_id' => $order->carrier_id ?? null,
            'source' => $order->source ?? null,
            'type_packaging' => $order->type_packaging ?? null,
        ];
    }

    private function storeShipment($order, $shipmentData)
    {
        return Shipment::create([
            'order_id' => $order->id,
            'shipment_id' => $shipmentData['id'],
            'external_id' => $shipmentData['external_id'],
            'delivery_id' => $shipmentData['delivery_id'],
            'status' => $shipmentData['status'],
            'status_name'  => $shipmentData['status_name'],
            'tracking_url' => $shipmentData['tracking'],
            'carrier_name' => $shipmentData['carrier']['name'],
            'carrier_logo' => $shipmentData['carrier']['logo'],
            'logistic_type' => $shipmentData['logistic_type'],
            'destination' => $shipmentData['destination'],
            'packages' => $shipmentData['packages'],
            'service_type' => $shipmentData['service_type'],
            'declared_value' => $shipmentData['declared_value'],
            'total' => $shipmentData['price'],
            'price_incl_tax' => $shipmentData['price_incl_tax'],
            'total_weight' => $shipmentData['total_weight'],
            'total_volume' => $shipmentData['total_volume'],
            'estimated_delivery' => $shipmentData['delivery_time']['estimated_delivery'],
            'shipment_created_at' => $shipmentData['created_at'],
            'full_details' => $shipmentData,
        ]);
    }

    public function getShipmentDocumentation($shipmentId, $what, $format = 'pdf')
    {
        $response = $this->makeApiCall('get', "/shipments/{$shipmentId}/documentation", [
            'what' => $what,
            'format' => $format,
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception('Error getting shipment documentation: ' . $response->body(), $response->status());
        }
    }    


}