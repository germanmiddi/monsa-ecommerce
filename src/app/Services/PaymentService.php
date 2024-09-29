<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use DB;

use App\Models\Order;
use App\Models\Payment;

class PaymentService
{

    public function store($order_id, $data)
    {
        $data = json_decode($data);
        
        try {
            DB::beginTransaction();

            $payment = new Payment();
            $payment->order_id = $order_id;
            $payment->transaction_id = $data->payment->data->transaction_id;
            $payment->qr_data = $data->payment->data->qr_data;
            $payment->payment_request_id = $data->payment->data->payment_request_id;
            $payment->checkout_url = $data->payment->data->checkout_url;
            $payment->amount = $data->payment->data->amount->value;

            $payment->save();
            DB::commit();

            return $payment;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
