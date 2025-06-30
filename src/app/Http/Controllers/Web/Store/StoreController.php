<?php

namespace App\Http\Controllers\Web\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Product;
use App\Models\Family;
use App\Models\Brand;
use App\Models\Category;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class StoreController extends Controller
{
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     if (!config('app.store_active')) {
        //         throw new NotFoundHttpException();
        //     }
        //     return $next($request);
        // });
    }

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
            'categories' => Category::where('status', 'active')->orderBy('name')->get(),
            'products' => Product::with('family', 'brand', 'categories')
                                    ->whereIn('idFamily', Family::where('active', true)->pluck('id'))
                                    ->whereIn('idBrand', Brand::where('active', true)->pluck('id'))
                                    ->where('price_public', '>', 0)
                                    ->active()
                                    ->get()
        ]);

    }

    // Add more methods as needed
}
