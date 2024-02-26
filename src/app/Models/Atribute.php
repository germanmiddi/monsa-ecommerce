<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Atribute extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'Atribute';

    protected $fillable = [
        'idfamily',
        'nombre',
        'slug',
        'valor'
    ];

    public function family()
    {
        return $this->belongsTo(Family::class, 'idfamily');
    }


}
