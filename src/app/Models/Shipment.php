<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [ 'order_id',
                            'shipment_id',
                            'external_id',
                            'delivery_id',
                            'status',
                            'status_name',
                            'tracking_url',
                            'carrier_name',
                            'carrier_logo',
                            'logistic_type',
                            'destination',
                            'packages',
                            'service_type',
                            'declared_value',
                            'total',
                            'price_incl_tax',
                            'total_weight',
                            'total_volume',
                            'estimated_delivery',
                            'shipment_created_at',
                            'full_details' ];

    protected $casts = [
        'full_details' => 'array',
        'estimated_delivery' => 'datetime',
        'destination' => 'array',
        'packages' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
}