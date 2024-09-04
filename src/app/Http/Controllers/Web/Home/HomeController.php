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

        $post = Post::with('post_category')->get()->toArray();
        $products = Product::whereHas('labels', function ($query) {
            $query->where('slug', 'carrousel_home');
        })->get();

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
    

}
