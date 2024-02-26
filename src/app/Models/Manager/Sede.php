<?php

namespace App\Models\Manager;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $table = 'sedes';
    protected $primaryKey = 'id';
    public $timestamps = true;
    
    protected $fillable = [
        'description',
    ];

    public function tramites(){
        return $this->hasMany(Tramite::class);
    }
}