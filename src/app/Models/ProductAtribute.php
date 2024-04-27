<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAtribute extends Model
{
    use HasFactory;

    protected $table = 'product_atribute';

    protected $fillable = [
        'id_product',
        'id_atribute',
        'valores',
        'is_variacion'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function atribute()
    {
        return $this->belongsTo(Atribute::class, 'id_atribute');
    }
    

}
