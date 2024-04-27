<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atribute extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'atribute';

    protected $fillable = [
        'idfamily',
        'nombre',
        'slug',
        'valor',
        'externalId'
    ];

    protected $casts = [
        'valor' => 'array'
    ];
    
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_atribute', 'id_atribute', 'id_product');
    }

    public function family()
    {
        return $this->belongsTo(Family::class, 'idfamily');
    }


}
