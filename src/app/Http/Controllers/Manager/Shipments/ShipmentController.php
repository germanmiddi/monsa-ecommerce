<?php

namespace App\Http\Controllers\Manager\Shipments;

use App\Http\Controllers\Controller;
use App\Models\Shipment;
use Illuminate\Http\Request;
use App\Services\DeliveryService;

class ShipmentController extends Controller
{
    protected $deliveryService;

    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    public function getDocumentation(Request $request, $shipmentId)
    {

        $request->validate([
            'what' => 'required|in:document,label',
            'format' => 'sometimes|in:pdf,zpl',
        ]);

        $what = $request->input('what');
        $format = $request->input('format', 'pdf');

        try {
            $response = $this->deliveryService->getShipmentDocumentation($shipmentId, $what, $format);

            return response()->json([
                'format' => $response['format'],
                'body' => $response['body'],
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function getZebraLabel($shipmentId)
    {

        $what = 'label';
        $format = 'zpl';

        try {
            $response = $this->deliveryService->getShipmentDocumentation($shipmentId, $what, $format);

            return response()->json([
                'format' => $response['format'],
                'body' => $response['body'],
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function processDevolution($shipmentId)
    {
        $response = $this->deliveryService->processDevolution($shipmentId);

        return response()->json($response);
    }
}
