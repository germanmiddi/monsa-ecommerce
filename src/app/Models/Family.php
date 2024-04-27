<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    
    protected $table = 'family';
    use HasFactory;

    public $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'imagen',
        'orden',
        'active',
        'externalId'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'idFamily');
    }
}
