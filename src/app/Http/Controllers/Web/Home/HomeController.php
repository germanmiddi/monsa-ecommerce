<?php

namespace App\Http\Controllers\Web\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Slider;
use App\Models\ContentBrand;
use App\Models\Content;
use App\Models\Product;
use App\Models\Suscripcion;
use App\Models\PostStatus;
class HomeController extends Controller
{
    /**
     * Display the home page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {

        $status_publicado = PostStatus::where('name', 'Publicado')->first()->id;
        $post = Post::with('post_category')
        ->where('post_status_id', $status_publicado)
        ->get()
        ->toArray();
        $products = Product::whereHas('labels', function ($query) {
            $query->where('slug', 'carrousel_home');
        })->where('price_public', '>', 0)->get();

        // Add your logic here
        return  Inertia::render('Web/Index', [
            'sliderDesktop' => Slider::where('type', 'desktop')->orderby('order')->get(),
            'sliderMobile'  => Slider::where('type', 'mobile')->orderby('order')->get(),
            'brands'  => ContentBrand::orderby('order')->get(),
            'content' => Content::where('page', 'home')->get(),
            'posts'   => $post,
            'products'   => $products
        ]);
    }
    
    public function suscribe(Request $request)
    {
        $suscripcion = Suscripcion::where('email', $request->email)->first();
        if($suscripcion){
            return response()->json(['message' => 'El email ya está suscrito'], 400);
        }
        Suscripcion::create($request->all());

        return response()->json(['message' => 'Te has suscrito correctamente']);
    }

}
