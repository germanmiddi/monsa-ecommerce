<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
class PaymentNotificationController extends Controller
{
    public function handleNotification(Request $request){
        DB::beginTransaction();

        try{
            $order_id = $request->order_id;
            $status = $request->status;
            $payment_method = $request->payment_method;
    
            $order = Order::find($order_id);
            if(!$order){
                return response()->json(['message' => 'Order not found'], 404);
            }
            $order->payment_status = $status;
            $order->payment_method = $payment_method;
            $order->save();
            DB::commit();

            Log::info('Payment notification received: ' . json_encode($request->all()));
            return response()->json(['message' => 'Payment notification received'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error processing payment notification: ' . $e->getMessage());
            return response()->json(['message' => 'Error processing payment notification'], 500);
        }
    }
}
