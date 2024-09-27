<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'featured',
        'date_published',
        'author'
    ];

    protected $casts = [
        'featured' => 'boolean',
    ];

    public function setSlugAttribute($value)
    {
        // Solo proceder si el valor del título ha cambiado
        // o si el modelo está siendo creado (id no establecido)
        if ($this->isDirty('title') || !$this->exists) {
            $slug = Str::slug($value); // Convierte el valor a un slug válido
            $originalSlug = $slug;
            $count = 2;
    
            // Verifica si ya existe un slug igual en la base de datos
            while (static::where('slug', $slug)->exists()) {
                // Ignora el propio slug del modelo si está actualizando
                if ($this->exists && static::where('slug', $slug)->where('id', '!=', $this->id)->doesntExist()) {
                    break;
                }
    
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
    
            $this->attributes['slug'] = $slug;
        }
        // Si el título no ha cambiado y el modelo ya existe, mantén el slug actual
        else if ($this->exists) {
            $this->attributes['slug'] = $this->getOriginal('slug');
        }
    }    
    

}
