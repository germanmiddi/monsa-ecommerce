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
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use Illuminate\Support\Facades\Log;
use App\Exports\ProductsTemplateExport;
use App\Models\Category;

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
            'categories' => Category::orderby('name')->get(),
        ]);
    }

    public function list()
    {
        $result = Product::query();
        /** Filtros */
        $length = request('length');

        if(request('sku')){
            $sku = json_decode(request('sku'));
            $result->where('sku',$sku);
        }

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

        if(request('label_id')){
            $label_id = json_decode(request('label_id'));
            $result->whereIn('id', function ($sub) use($label_id) {
                $sub->selectRaw('product.id')
                    ->from('product')
                    ->join('label_product', 'product.id', '=', 'label_product.product_id')
                    ->where('label_product.label_id', $label_id);
            });
        }

        if(request('category_id')){
            $category_id = json_decode(request('category_id'));
            $result->whereIn('id', function ($sub) use($category_id) {
                $sub->selectRaw('product.id')
                    ->from('product')
                    ->join('category_products', 'product.id', '=', 'category_products.product_id')
                    ->where('category_products.category_id', $category_id);
            });
        }

        if(request('promo_active')){
            $result->where('promo_active', true);
        }

        if(request('stock_filter') !== null){
            $stock_filter = request('stock_filter');
            if($stock_filter === '0'){
                $result->where('stock_disponible', '<',1);
            }elseif($stock_filter === '1'){
                $result->where('stock_disponible', '>=',1);
            }
        }
        if(request('price_filter') !== null){
            $price_filter = request('price_filter');
            if($price_filter === '0'){
                $result->where('precio','<',1);
            }elseif($price_filter === '1'){
                $result->where('precio', '>', 0);
            }
        }
        if(request('visibility_filter') !== null){
            $visibility_filter = request('visibility_filter');
            if($visibility_filter === '0'){
                $result->where('is_active', true);
            }elseif($visibility_filter === '1'){
                $result->where('is_active', false);
            }
        }

        // dd($stock_filter );
        // dd($result->toSql());
        // return $result->with('family', 'brand', 'labels')
        return $result->with('family', 'brand', 'labels', 'categories')
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
            $product->promo_active = $request->promo_active;
            $product->promo_price = $request->promo_price;
            $product->promo_start_date = $request->promo_start_date;
            $product->promo_end_date = $request->promo_end_date;
            $product->stock_disponible = $request->stock_disponible;
            $product->descripcion = $request->descripcion;
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

                        // Manejo de categorías - solo sincronizar existentes
            $categoryIds = array();
            if ($request->categoryDetails) {
                foreach ($request->categoryDetails as $categoryId) {
                    // Solo agregar si la categoría existe
                    if (Category::find($categoryId)) {
                        $categoryIds[] = $categoryId;
                    }
                }
            }
            $product->categories()->sync($categoryIds);

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

    public function massiveToggleActive(Request $request)
    {
        $products = $request->products;

        foreach ($products as $product) {
            $productModel = Product::find($product['id']);
            $productModel->is_active = $request->is_active;
            $productModel->save();

        }
        return response()->json(['message' => 'Productos actualizados correctamente'], 200);
    }
    public function importDetails(Request $request)
    {
        if ($request->file('file')) {
            try {
                $archivo = $request->file('file');
                Log::info('Se ha iniciado el proceso de Importación de Productos');
                $import = new ProductsImport();

                Excel::import($import, $archivo);
                $status = $import->getImportResult();
                return response()->json(['message' => 'Se ha finalizado el proceso de importacion.', 'result' => $status], 200);

            } catch (\Throwable $th) {
                Log::error('Error al procesar el archivo', ['error' => $th->getMessage()]);
                return response()->json(['message' => 'Error al procesar el archivo'], 203);
            }
        } else {
            return response()->json(['message' => 'Error al procesar el importador. Contacte al Administrador'], 203);
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new ProductsTemplateExport(), 'template_productos.xlsx');
    }

}
