<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PostCategory extends Model
{
    use HasFactory, SoftDeletes;
    //set table name
    protected $table = 'post_categories';
    protected $fillable = ['name',
                            'slug', 
                            'description', 
                            'image', 
                            'parent_id', 
                            'order', 
                            'featured', 
                            'menu', 
                            'active'];


    protected $casts = [
        'featured' => 'boolean',
        'menu' => 'boolean',
        'active' => 'boolean',
    ];
    
    public function posts()
    {
        return $this->hasMany(Post::class, 'post_category_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(PostCategory::class, 'parent_id');
    }   
    public function children()
    {
        return $this->hasMany(PostCategory::class, 'parent_id');
    }   
    


}
