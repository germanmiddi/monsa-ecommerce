<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    
    protected $table = 'labels';
    use HasFactory;

    public $fillable = [
        'nombre',
        'slug',
        'active'
    ];

    public function products(){
        return $this->belongsToMany(Product::class, 'label_product');
    }
}
