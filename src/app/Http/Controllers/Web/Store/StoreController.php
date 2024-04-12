<?php

namespace App\Http\Controllers\Web\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Family;
use App\Models\Brand;

class StoreController extends Controller
{
    /**
     * Display the home page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // Add your logic here
        return  Inertia::render('Web/Store/Index', [
            'families' => Family::where('active', true)->orderBy('orden')->get(),
            'brands'   => Brand::where('active', true)->orderBy('orden')->get(),
            'products' => Product::all()
        ]);
        
    }
    
    // Add more methods as needed
}
