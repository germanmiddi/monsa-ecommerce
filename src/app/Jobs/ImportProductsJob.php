<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

use App\Models\Product;
use App\Models\Family;
use App\Models\Brand;
use App\Models\Atribute;
use App\Models\ProductAtribute;
use App\Models\Setting;
use Carbon\Carbon;

class ImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $products;

    public function __construct($products)
    {
        $this->products = $products;
    }

    public function handle()
    {
        Log::info("Inicio de importación de productos");

        $count = 0;
        foreach ($this->products as $product) {
            DB::beginTransaction();

            try {

                $id_family = Family::where('externalId', $product['idFamilia'])->value('id');
                $id_brand = Brand::where('externalId', $product['idMarca'])->value('id');
                $is_active = 0;

                if(!$id_family || !$id_brand){
                    Log::error('Failed to store product: ' . json_encode($product));
                    continue;
                }
                
                // if($product['visibilidad'] === 'oculto'){
                //     $is_active = 0;
                // }

                Log::info('price_public' . $product['price_public'] );
                
                $productLocal = Product::where('externalId', $product['idProducto'])->first();  

                if($productLocal){
                    //update some fields
                    $productLocal->update([
                            'nombre'    => $product['nombre'],
                            'modelo'    => $product['modelo'],
                            'precio'    => $product['precio'],
                            'imagen'    => $product['imagen'],
                            'price_public' => $product['price_public'],
                            'peso'   => $product['peso'],
                            'search' => $product['search'],
                            'alto'   => $product['alto'],
                            'ancho'  => $product['ancho'],
                            'largo'  => $product['largo'],
                            'updated_at' => now(),
                        ]
                    );

                    if(!$productLocal){
                        Log::error('Failed to update product: ' . json_encode($productLocal));
                    }else{
                        Log::info('Product updated: ' . json_encode($productLocal));
                    }
                }else{
                    //create whole product 
                    $productLocal = Product::create(
                        [
                            'idProducto'  => $product['idProducto'],
                            'idFamily'    => $id_family,
                            'idBrand'     => $id_brand,
                            'nombre'      => $product['nombre'],
                            'slug'        => $product['slug'],
                            'modelo'      => $product['modelo'],
                            'descripcion' => $product['descripcion'],
                            'imagen'      => $product['imagen'],
                            'sku'         => $product['sku'],
                            'precio'      => $product['precio'],
                            'price_public'=> $product['price_public'],
                            'dimensiones' => $product['dimensiones'],
                            'peso'        => $product['peso'],
                            'stock'       => $product['stock'],
                            'stock_quantity' => $product['stock_quantity'],
                            'visibilidad'    => $product['visibilidad'],
                            'state'      => $product['state'],
                            'show'       => $product['show'],
                            'search'     => $product['search'],
                            'alto'       => $product['alto'],
                            'ancho'      => $product['ancho'],
                            'largo'      => $product['largo'],
                            'externalId' => $product['idProducto'],
                            'is_active'  => $is_active
                        ]
                    );
                    if(!$productLocal){
                        Log::error('Failed to store product: ' . json_encode($product));
                    }else{
                        Log::info('Product created: ' . json_encode($productLocal));
                    }

                }


                if(isset($product['atributos'])){
                    foreach ($product['atributos'] as $atributo) {
                        $id_atributo = Atribute::where('externalId', $atributo['idAtributo'])->value('id');
                        if(!$id_atributo){
                            Log::error('ID Atributo externo no encontrado localmente: ' . json_encode($product));
                            continue;
                        }
                        $productAtribute = ProductAtribute::updateOrCreate(
                            ['id_product' => $productLocal->id, 'id_atribute' => $id_atributo],
                            [
                                'valores' => $atributo['valores']
                            ]
                        );

                        if(!$productAtribute){
                            Log::error('Failed to store product atribute: ' . json_encode($product));
                        }
                    }
                }

                DB::commit();
                $count++;

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to store product: ' . $e->getMessage());
                
            }

        }

        $setting = Setting::where('key', 'last_import_product')->first();
        $setting->value = Carbon::now()->format('d-m-Y H:i:s');
        $setting->save();

        Log::info("Se importaron $count productos");
        Log::error("Hubo errores al importar los siguientes productos ");
        
    }
}
