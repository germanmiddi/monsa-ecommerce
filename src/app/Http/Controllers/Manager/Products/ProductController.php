<?php

namespace App\Http\Controllers\Manager\Products;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Family;
use App\Models\Label;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;


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
            'labels' => Label::orderby('nombre')->active()->get(),
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

        return $result->with('family', 'brand', 'labels')
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
        try{
            $product->is_active = $request->is_active;
            $product->promo_text = $request->promo_text;
            $labelIds = array();
            //Obtengo los ID de las etiquetas.
            foreach ($request->labelDetails as $value) {
                // Buscar el Lable por nombre
                $label = Label::firstOrCreate(
                    ['nombre' => $value],
                    [
                        'nombre' => $value, 
                        'slug' => Str::slug(Str::ascii($value))
                        ]
                    );
                    $labelIds[] = $label->id;
                }
            $product->labels()->sync($labelIds);
            $product->save();

            return response()->json(['message' => 'Producto actualizado correctamente'],200);
        }catch(\Exception $e){
            $msg = $e->getMessage();
            return response()->json(['message' => 'Error al actualizar el producto', 'error'=> $msg ], 500);
        }
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
