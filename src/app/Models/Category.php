<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'image',
        'status',
        'slug',
        'meta_title',
        'meta_description',
        'parent_id',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            $slug = \Str::slug($category->name);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

            $category->slug = $count ? "{$slug}-{$count}" : $slug;
        });

        static::updating(function ($category) {
            if ($category->isDirty('name')) {
                $slug = \Str::slug($category->name);
                $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->where('id', '!=', $category->id)->count();

                $category->slug = $count ? "{$slug}-{$count}" : $slug;
            }
        });
    }


    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Relación many-to-many con productos
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_products');
    }

    // Métodos helper para facilitar la gestión
    public function attachProduct($productId)
    {
        return $this->products()->attach($productId);
    }

    public function detachProduct($productId)
    {
        return $this->products()->detach($productId);
    }

    public function syncProducts($productIds)
    {
        return $this->products()->sync($productIds);
    }
}

