<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 
        'transaction_id', 
        'qr_data', 
        'payment_request_id', 
        'checkout_url', 
        'amount', 
        'currency',
        'status',
        'payment_check_status'
    ];

    protected $casts = [
        'payment_check_status' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}