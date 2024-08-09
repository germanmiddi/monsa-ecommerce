<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'order_user_id',
        'order_status_id',
        'order_client_id',
        'payment_order_number',
        'payment_status',
        'delivery_number',
        'delivery_traking_number',
        'delivery_status',
        'delivery_amount',
        'subtotal',
        'total'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'order_client_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'orderitems_order_id');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function shipments()
    {
        return $this->hasMany(Shipment::class);
    }
}
