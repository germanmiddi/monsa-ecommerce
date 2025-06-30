<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';

    protected $appends = ['sale_price', 'stock_real'];

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
                    'is_active',
                    'promo_text',
                    'promo_active',
                    'promo_price',
                    'promo_start_date',
                    'promo_end_date',
                    'stock_disponible',
                    'stock_reservado'

                ];

    protected $casts = [
        'imagen' => 'array', // Cast para las imágenes
        'dimensiones' => 'array', // Cast para las dimensiones
        'search' => 'array', // Cast para los términos de búsqueda
        'is_active' => 'boolean',
        'promo_active' => 'boolean',
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

    // Relación many-to-many con categorías
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products');
    }

    // Métodos helper para facilitar la gestión de categorías
    public function attachCategory($categoryId)
    {
        return $this->categories()->attach($categoryId);
    }

    public function detachCategory($categoryId)
    {
        return $this->categories()->detach($categoryId);
    }

    public function syncCategories($categoryIds)
    {
        return $this->categories()->sync($categoryIds);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '1');
    }

    public function getSalePriceAttribute()
    {
        return $this->promo_active ? $this->promo_price : $this->price_public;
    }

    public function getStockRealAttribute()
    {
        return $this->stock_disponible - $this->stock_reservado;
    }

}
