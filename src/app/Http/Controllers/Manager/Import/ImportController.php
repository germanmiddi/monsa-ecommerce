<?php

namespace App\Http\Controllers\Manager\Import;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Jobs\ImportProductsJob;

use App\Models\Family;
use App\Models\Brand;
use App\Models\Atribute;
use App\Models\Product;
use App\Models\ProductAtribute;
use App\Models\Setting;

use Carbon\Carbon;
class ImportController extends Controller
{
 
    
    /***********************************************/
    /* * Import products from the external API     */
    /***********************************************/

    public function import_products(){

        $products = $this->_get_products();
        
        if(!$products) {
            return response()->json(['error' => 'An error occurred while trying to fetch products: '], 500);
        }else{
            // $result = $this->_storeProducts($products);
            // return $result;
            ImportProductsJob::dispatch($products);
            return response()->json(['message' => 'Products are being imported'],200);            
        }

    }

    // public function _storeProducts($products){
            
    //     $count = 0;
    //     $errorList = [];

    //     foreach ($products as $product) {
    //         DB::beginTransaction();

    //         try {

    //             $id_family = Family::where('externalId', $product['idFamilia'])->value('id');
    //             $id_brand = Brand::where('externalId', $product['idMarca'])->value('id');

    //             if(!$id_family || !$id_brand){
    //                 $errorList[] = $product;
    //                 continue;
    //             }
    //             // dd($product['idFamilia'], $id_family, $product['idMarca'], $id_brand);

    //             $productModel = Product::updateOrCreate(
    //                 ['externalId' => $product['idProducto']],
    //                 [
    //                     'idProducto' => $product['idProducto'],
    //                     'idFamily' => $id_family,
    //                     'idBrand'   => $id_brand,
    //                     'nombre'    => $product['nombre'],
    //                     'slug'      => $product['slug'],
    //                     'modelo'    => $product['modelo'],
    //                     'descripcion' => $product['descripcion'],
    //                     'imagen' => $product['imagen'],
    //                     'sku'    => $product['sku'],
    //                     'precio' => $product['precio'],
    //                     'dimensiones' => $product['dimensiones'],
    //                     'peso'  => $product['peso'],
    //                     'stock' => $product['stock'],
    //                     'stock_quantity' => $product['stock_quantity'],
    //                     'visibilidad'    => $product['visibilidad'],
    //                     'state'  => $product['state'],
    //                     'show'   => $product['show'],
    //                     'search' => $product['search'],
    //                     'alto'   => $product['alto'],
    //                     'ancho'  => $product['ancho'],
    //                     'largo'  => $product['largo'],
    //                     'externalId' => $product['idProducto']
    //                 ]
    //             );

    //             if(isset($product['atributos'])){
    //                 foreach ($product['atributos'] as $atributo) {
    //                     $id_atributo = Atribute::where('externalId', $atributo['idAtributo'])->value('id');
    //                     if(!$id_atributo){
    //                         $errorList[] = $product;
    //                         continue;
    //                     }
    //                     $productAtribute = ProductAtribute::updateOrCreate(
    //                         ['id_product' => $productModel->id, 'id_atribute' => $id_atributo],
    //                         [
    //                             'valores' => $atributo['valores']
    //                         ]
    //                     );
    //                 }
    //             }

    //             DB::commit();
    //             $count++;

    //         } catch (\Exception $e) {
    //             DB::rollBack();
    //             Log::error('Failed to store product: ' . $e->getMessage());
    //             $errorList[] = $product;
    //         }

    //     }

    //     return response()->json([
    //         'success' => $count . ' products stored successfully',
    //         'errors' => $errorList
    //     ]);

    // }

    public function _get_products() {
        // Ensure the API URL is set in the environment configuration
        $apiUrl = env('MONSA_API_URL');
        
        if (!$apiUrl) {
            return response()->json(['error' => 'API URL is not set.'], 422);
        }

        $url = $apiUrl . 'api/get_products';

        try {
            $httpResponse = Http::withHeaders(['Accept' => 'application/json'])
                                 ->get($url);

            // Check if the HTTP request was successful
            if ($httpResponse->successful()) {
                return $httpResponse->json();
            } else {
                Log::error('Failed to retrieve Products. Status code: ' . $httpResponse->status());
                return false;
            }
        } catch (\Exception $e) {
            // Log the exception or handle it according to your application's requirements
            Log::error('An error occurred while trying to fetch Products: ' . $e->getMessage());
            return false;    
        }
    }


    /***********************************************/
    /* * Import familias from the external API     */
    /***********************************************/

    public function import_families(){

        $families = $this->_get_families();

        if(!$families) {
            return response()->json(['error' => 'An error occurred while trying to fetch families: '], 500);
        }else{
            $result = $this->_storeFamilies($families);
            return response()->json(['message' => 'Families are being imported'],200);    
            //return $result;
            // return response()->json($families);
        }

    }

    public function _storeFamilies($families) {
        
        $count = 0;
        $errorList = [];

        foreach ($families as $family) {
            DB::beginTransaction();
            try {
                $familyModel = Family::updateOrCreate(
                    ['externalId' => $family['idFamilia']],
                    [
                        'nombre' => $family['nombre'],
                        'slug' => $family['slug'],
                        'orden' => $family['orden'],
                        'externalId' => $family['idFamilia']
                    ]
                );
                DB::commit();
                $count++;
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to store family: ' . $e->getMessage());
                $errorList[] = $family;
            }

        }
        $setting = Setting::where('key', 'last_import_families')->first();
        $setting->value = Carbon::now()->format('d-m-Y H:i:s');
        $setting->save();

        return response()->json([
            'success' => $count . ' families stored successfully',
            'errors' => $errorList
        ]);
    }

    public function _get_families() {
        // Ensure the API URL is set in the environment configuration
        $apiUrl = env('MONSA_API_URL');
        
        if (!$apiUrl) {
            return response()->json(['error' => 'API URL is not set.'], 422);
        }

        $url = $apiUrl . 'api/get_families';

        try {
            $httpResponse = Http::withHeaders(['Accept' => 'application/json'])
                                 ->get($url);

            // Check if the HTTP request was successful
            if ($httpResponse->successful()) {
                return $httpResponse->json();

            } else {
                Log::error('Failed to retrieve families. Status code: ' . $httpResponse->status());
                return false;
            }
        } catch (\Exception $e) {
            // Log the exception or handle it according to your application's requirements
            Log::error('An error occurred while trying to fetch families: ' . $e->getMessage());
            return false;            
        }
    }

    /***********************************************/
    /* * Import Marcas from the external API     */
    /***********************************************/

    public function import_brands(){

        $brands = $this->_get_brands();

        if(!$brands) {
            return response()->json(['error' => 'An error occurred while trying to fetch brands: '], 500);
        }else{
            $result = $this->_storeBrands($brands);
            return response()->json(['message' => 'Brands are being imported'],200);    
            //return $result;
            // return response()->json($families);
        }

    }

    public function _storeBrands($brands) {
        
        $count = 0;
        $errorList = [];

        foreach ($brands as $brand) {
            DB::beginTransaction();

            try {

                $brandModel = Brand::updateOrCreate(
                    ['externalId' => $brand['idMarca']],
                    [
                        'nombre' => $brand['nombre'],
                        'slug' => $brand['slug'],
                        'orden' => $brand['orden'],
                        'externalId' => $brand['idMarca']
                    ]
                );

                DB::commit();
                $count++;

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to store brand: ' . $e->getMessage());
                $errorList[] = $brand;
            }
        }


        $setting = Setting::where('key', 'last_import_brand')->first();
        $setting->value = Carbon::now()->format('d-m-Y H:i:s');
        $setting->save();

        return response()->json([
            'success' => $count . ' brands stored successfully',
            'errors' => $errorList
        ]);
    }

    public function _get_brands() {
        // Ensure the API URL is set in the environment configuration
        $apiUrl = env('MONSA_API_URL');
        
        if (!$apiUrl) {
            return response()->json(['error' => 'API URL is not set.'], 422);
        }

        $url = $apiUrl . 'api/get_brands';

        try {
            $httpResponse = Http::withHeaders(['Accept' => 'application/json'])
                                 ->get($url);

            // Check if the HTTP request was successful
            if ($httpResponse->successful()) {
                return $httpResponse->json();
            } else {
                // Handle the error based on the status code
                Log::error('Failed to retrieve brands. Status code: ' . $httpResponse->status());
                return false;
            }
        } catch (\Exception $e) {
            // Log the exception or handle it according to your application's requirements
            Log::error('An error occurred while trying to fetch brands: ' . $e->getMessage());
            return false;     
        }
    }

    /***********************************************/
    /* * Import Atributos from the external API     */
    /***********************************************/

    public function import_atributes(){

        $atributes = $this->_get_atributes();

        if(!$atributes) {
            return response()->json(['error' => 'An error occurred while trying to fetch Atributes: '], 500);
        }else{
            $result = $this->_storeAtributes($atributes);
            return response()->json(['message' => 'Atributes are being imported'],200);    
            //return $result;
            
        }

    }

    public function _storeAtributes($atributes) {
        
        $count = 0;
        $errorList = [];

        foreach ($atributes as $atribute) {
            DB::beginTransaction();


            try {

                $id_family = Family::where('externalId', $atribute['idfamilia'])->value('id');

                if(!$id_family){
                    $errorList[] = $atribute;
                    continue;
                }
                $atributeModel = Atribute::updateOrCreate(
                    ['externalId' => $atribute['idAtributo']],
                    [
                        'idfamily'  => $id_family,
                        'nombre'    => $atribute['nombre'],
                        'slug'      => $atribute['slug'],
                        'valor'     => $atribute['valor'],
                        'externalId' => $atribute['idAtributo']
                    ]
                );
                DB::commit();
                $count++;

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to store atribute: ' . $e->getMessage());
                $errorList[] = $atribute;
            }

        }

        $setting = Setting::where('key', 'last_import_attributes')->first();
        $setting->value = Carbon::now()->format('d-m-Y H:i:s');
        $setting->save();

        return response()->json([
            'success' => $count . ' atributes stored successfully',
            'errors' => $errorList
        ]);
    }

    public function _get_atributes() {
        // Ensure the API URL is set in the environment configuration
        $apiUrl = env('MONSA_API_URL');
        
        if (!$apiUrl) {
            return response()->json(['error' => 'API URL is not set.'], 422);
        }

        $url = $apiUrl . 'api/get_atributos';

        try {
            $httpResponse = Http::withHeaders(['Accept' => 'application/json'])
                                 ->get($url);

            // Check if the HTTP request was successful
            if ($httpResponse->successful()) {
                return $httpResponse->json();
            } else {
                // Handle the error based on the status code
                Log::error('Failed to retrieve atributes. Status code: ' . $httpResponse->status());
                return false;
            }
        } catch (\Exception $e) {
            // Log the exception or handle it according to your application's requirements
            Log::error('An error occurred while trying to fetch atributes: ' . $e->getMessage());
            return false;     
        }
    }
}