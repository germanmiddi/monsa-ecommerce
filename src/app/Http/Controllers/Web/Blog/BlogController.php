<?php

namespace App\Http\Controllers\Web\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;
use App\Models\PostStatus;
class BlogController extends Controller
{
    // Add your controller methods here

    public function list()
    {
        $status_publicado = PostStatus::where('name', 'Publicado')->first()->id;
        return Inertia::render('Web/Blog/List',[
            'posts'     => Post::where('post_status_id', $status_publicado)
                                ->orderBy('created_at', 'desc')
                                ->paginate(999)
                                ->withQueryString()
                                ->through(fn ($post) => [
                                        'id'          => $post->id,
                                        'post_category' => $post->post_category()->first()->name,
                                        'title'       => $post->title,
                                        'date_published' => $post->date_published,
                                        'post_status' => $post->postStatus()->first()->name,
                                        'content'   => $post->content,
                                        'image'     => $post->image,
                                        'slug'      => $post->slug,
                                        'created_at'  => $post->created_at->format('d-m-Y'),
                                    ])
                            ]);
    }

    public function single($slug)
    {
        return Inertia::render('Web/Blog/Single',[
            'post'     => Post::where('slug', $slug)
                                ->with('post_category', 'postStatus')
                                ->first()
        ]);
    }
}
