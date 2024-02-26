<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';

    public $fillable = [
                    'idFamily',
                    'idBrand',
                    'nombre',
                    'slug',
                    'modelo',
                    'descripcion',
                    'imagen',
                    'sku',
                    'precio',
                    'dimensiones',
                    'peso',
                    'stock',
                    'stock_type',
                    'stock_fijo',
                    'stock_quantity',
                    'stock_limit1',
                    'stock_limit2',
                    'visibilidad',
                    'state',
                    'show_home',
                    'show',
                    'idParent',
                    'search',
                    'alto',
                    'ancho',
                    'largo' ];


    public function family()
    {
        return $this->belongsTo(Family::class, 'idFamily');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'idBrand');
    }

    public function atributes()
    {
        return $this->hasMany(Atribute::class, 'idProduct');
    }
                    

}
