<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'orderitems_order_id',
        'orderitems_product_id',
        'quantity',
        'price',
        'total'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderitems_order_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'orderitems_product_id');
    }
}
