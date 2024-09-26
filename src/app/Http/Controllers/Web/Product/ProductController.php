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
        $prod = $product->load('atributes', 'atributes.atribute');

        $relatedProducts = Product::where('idFamily', $prod->idFamily)
                                  ->where('id', '!=', $prod->id)
                                  ->limit(4)
                                  ->get();
        // Add your logic here
        return Inertia::render('Web/Product/Index', [
            'product' => $prod,
            'relatedProducts' => $relatedProducts
        ]);
        
    }
    // {
    //     dd($request->id);
    //     // Add your logic here
    //     return  Inertia::render('Web/Product/Index');
        
    // }
    
    // Add more methods as needed
}
