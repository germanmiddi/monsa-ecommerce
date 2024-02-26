<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'brand';

    protected $fillable = [
        'nombre',
        'slug',
        'orden',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'idbrand');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }   

}
