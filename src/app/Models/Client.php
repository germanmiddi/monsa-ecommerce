<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'fullname',
        'email',
        'cellphone',
        'address',
        'city',
        'state',
        'zip',
        'document',
        'street_num',
        'street_extras',
        'cuit'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'order_client_id');
    }

}
