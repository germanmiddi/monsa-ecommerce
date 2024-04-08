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

        // Add your logic here
        return  Inertia::render('Web/Index', [
            'sliderDesktop' => Slider::where('type', 'desktop')->get(),
            'sliderMobile'  => Slider::where('type', 'mobile')->get(),
            'brands'  => ContentBrand::all(),
            'content' => Content::where('page', 'home')->get(),
            'posts'   => $post,
        ]);
    }
    

}
