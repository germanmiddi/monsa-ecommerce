<?php

namespace App\Http\Controllers\Web\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;


class ProductController extends Controller
{
    /**
     * Display the home page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Product $product)
    {
        // Add your logic here
        return  Inertia::render('Web/Product/Index', [
            'product' => $product
        ]);
        
    }
    // {
    //     dd($request->id);
    //     // Add your logic here
    //     return  Inertia::render('Web/Product/Index');
        
    // }
    
    // Add more methods as needed
}
