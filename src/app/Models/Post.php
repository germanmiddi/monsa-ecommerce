<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 
                            'slug', 
                            'content', 
                            'image', 
                            'featured',
                            'date_published',
                            'author',
                            'post_status_id',
                            'post_category_id', 
                            'post_user_id'];

    protected $casts = [
        'featured' => 'boolean',
        'menu' => 'boolean',
        'active' => 'boolean',
        //'date_published' => 'date:Y-m-d',
    ];

    public function postStatus()
    {
        return $this->belongsTo(PostStatus::class, 'post_status_id') ;
    }

    public function post_category()
    {
        return $this->belongsTo(PostCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'post_user_id');
    }

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
    
    /**
     * Get the date_published attribute in DD/MM/YYYY format.
     *
     * @param  string  $value
     * @return string
     */
    public function getDatePublishedAttribute($value)
    {
        // Verifica si $value ya es una instancia de Carbon para evitar re-cast
        if (!$value instanceof \Carbon\Carbon) {
            // Si no es una instancia de Carbon, intenta crearla. Asegúrate de manejar nulls y valores inválidos como prefieras
            $value = \Carbon\Carbon::parse($value);
        }

        // Formatea y devuelve la fecha en formato DD/MM/YYYY
        return $value->format('d/m/Y');
    }
    /* public function getDatePublishedAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y');
    } */

}
