<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostStatus extends Model
{
    use HasFactory;
    //set table name
    protected $table = 'post_statuses';
    protected $fillable = ['name'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

}
