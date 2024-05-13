<?php

namespace App\Http\Controllers\Manager\Products;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Family;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return  Inertia::render('Manager/Product/Index',[
            'families' => Family::orderby('nombre')->get(),
            'brands' => Brand::orderby('nombre')->get(),
        ]);
    }

    public function list()
    {
        $result = Product::query();
        /** Filtros */
        $length = request('length');

        if(request('modelo')){
            $modelo = json_decode(request('modelo'));
            $result->where('modelo','LIKE','%'.$modelo.'%');
        }

        if(request('family_id')){
            $family_id = json_decode(request('family_id'));
            $result->where('idFamily', $family_id);
        }

        if(request('brand_id')){
            $brand_id = json_decode(request('brand_id'));
            $result->where('idBrand', $brand_id);
        }

        return $result->with('family', 'brand')
                    ->orderBy('created_at', 'desc')
                    ->paginate($length)
                    ->withQueryString();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
