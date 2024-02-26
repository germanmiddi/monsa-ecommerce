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
        'date_published' => 'date',
    ];

    public function postStatus()
    {
        return $this->belongsTo(PostStatus::class);
    }

    public function postCategory()
    {
        return $this->belongsTo(PostCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setSlugAttribute($value)
    {
        $slug = Str::slug($value); // Convierte el valor a un slug válido
        $originalSlug = $slug;
        $count = 2;

        // Verifica si ya existe un slug igual en la base de datos
        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        $this->attributes['slug'] = $slug;
    }    
    
}
