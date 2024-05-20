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
                    'price_public',
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
                    'largo',
                    'externalId',
                    'is_active'];

    protected $casts = [
        'imagen' => 'array', // Cast para las imágenes
        'dimensiones' => 'array', // Cast para las dimensiones
        'search' => 'array', // Cast para los términos de búsqueda
        'is_active' => 'boolean'
    ];

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
        return $this->hasMany(ProductAtribute::class, 'id_product');
    }

    public function labels(){
        return $this->belongsToMany(Label::class, 'label_product');
    }


}
