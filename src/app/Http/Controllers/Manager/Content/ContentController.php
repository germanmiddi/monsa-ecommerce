<?php

namespace App\Http\Controllers\Manager\Content;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Slider;
use App\Models\ContentBrand;
use App\Models\ContentBanner;
use App\Models\Content;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Constraint\Count;

class ContentController extends Controller
{
    public function index()
    {
        return Inertia::render('Manager/Content/Index',
            [
                'aboutus' => Content::where('page', 'aboutus')->get(),
            ]
        );
    }

    public function list()
    {
        return response()->json([
            'desktop'   => Slider::where('type','desktop')->orderby('order')->get(),
            'mobile'    => Slider::where('type','mobile')->orderby('order')->get()
        ]);
    }

    public function updateContent(Request $request)
    {
        $items = $request->input('items');
    
        foreach ($items as $item) {
            $content = Content::find($item['id']);
            if ($content) {
                $content->content = $item['content'];
                $content->save();
            }
        }
    
        return response()->json(['message' => 'All contents updated successfully']);
    }



    public function sliderStore(Request $request)
    {
        DB::beginTransaction();    
        try{
            $slider = new Slider();
            
            if($request->file()) {
                $file_name = time().'_'.$request->file('image')->getClientOriginalName();
                $file_path = $request->file('image')->storeAs('slider', $file_name, 'public');
                $slider->image = $file_path;
            }
            
            $slider->title = $request->title ?? null;
            $slider->body = $request->body ?? null;
            $slider->button_text = $request->button_text ?? null;
            $slider->button_link = $request->button_link ?? null;
            $slider->order = 0;
            $slider->is_active = true;
            $slider->type = $request->type;
            $slider->save();

            DB::commit();
            return response()->json(['message' => 'Slider created successfully'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            $msg = $e->getMessage();
            return response()->json(['message' => 'Error creating slider', 
                                     'detail'  => $msg ], 500);
        }
    }

    public function sliderDelete(Slider $slider){

        try{
            // Borrar el archivo físico
            if( $slider->image && 
                Storage::disk('public')->exists($slider->image)){
                    Storage::disk('public')->delete($slider->image);
            }

            $slider->delete();
            return response()->json(['message' => 'El Sliders se ha eliminado correctamente'], 200);
            // DB::commit();
        }catch(\Exception $e){
            // DB::rollBack();
            $msg = $e->getMessage();
            return response()->json(['message' => 'Error al momento de crear el Slider', 
            'detail'  => $msg ], 500);
        }
        
        //return response()->json(['message' => 'Error al momento de crear el Slider'], 200);
    }

    public function sliderOrder(Request $request)
    {
        DB::beginTransaction();    
        try{
            $datosJSON = $request->getContent();
            $datosDecodificados = json_decode($datosJSON, true); // El segundo parámetro true convierte el JSON en un array asociativo
            $position = 1;
            
            foreach ($datosDecodificados as $value) {
                Slider::where('id',$value['id'])->update(
                    [
                        'order' => $position
                    ]
                );
                $position++;
            }
            DB::commit();
            return response()->json(['message' => 'El Sliders se ha creado correctamente'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            $msg = $e->getMessage();
            return response()->json(['message' => 'Error al momento de crear el Slider', 
                                     'detail'  => $msg ], 500);
        }
    }



    public function brandList()
    {
        $brands = ContentBrand::orderby('order')->get();
        return response()->json($brands);
    }

    public function brandStore(Request $request)
    {
        DB::beginTransaction();    
        try{
            $brand = new ContentBrand();
            
            if($request->file()) {
                $file_name = time().'_'.$request->file('image')->getClientOriginalName();
                $file_path = $request->file('image')->storeAs('brand', $file_name, 'public');
                $brand->image = $file_path;
            }
            
            $brand->order = 0;
            $brand->is_active = true;
            $brand->save();

            DB::commit();
            return response()->json(['message' => 'Brand created successfully'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            $msg = $e->getMessage();
            return response()->json(['message' => 'Error creating brand', 
                                     'detail'  => $msg ], 500);
        }
    }

    public function brandDelete(ContentBrand $contentBrand){

        try{
            // Borrar el archivo físico
            if( $contentBrand->image && 
                Storage::disk('public')->exists($contentBrand->image)){
                    Storage::disk('public')->delete($contentBrand->image);
            }

            $contentBrand->delete();
            // DB::commit();
        }catch(\Exception $e){
            // DB::rollBack();
            $msg = $e->getMessage();
            return response()->json(['message' => 'Error deleting marca', 
            'detail'  => $msg ], 500);
        }
        
        return response()->json(['message' => 'Marca deleted'], 200);
    }

    public function brandOrder(Request $request)
    {
        DB::beginTransaction();    
        try{
            $datosJSON = $request->getContent();
            $datosDecodificados = json_decode($datosJSON, true); // El segundo parámetro true convierte el JSON en un array asociativo
            $position = 1;
            
            foreach ($datosDecodificados as $value) {
                ContentBrand::where('id',$value['id'])->update(
                    [
                        'order' => $position
                    ]
                );
                $position++;
            }
            DB::commit();
            return response()->json(['message' => 'Marca created successfully'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            $msg = $e->getMessage();
            return response()->json(['message' => 'Error creating marca', 
                                     'detail'  => $msg ], 500);
        }
    }


    public function getContent($page, $section = null)
    {
        
        if ($section === null) {
            $content = Content::where('page', $page)->get();
        } else {
            $content = Content::where('page', $page)
                              ->where('section', $section)
                              ->get();
        }

        return response()->json($content);
    }

    public function aboutStore(Request $request)
    {
        DB::beginTransaction();    
        try{
            $items = $request->input('items');
    
            foreach ($items as $item) {
                $content = Content::find($item['id']);
                if($content['element'] === 'img'){
                    //dd($request);
                    if($request->file()) {
                        $file_name = time().'_'.$request->file('image')->getClientOriginalName();
                        $file_path = $request->file('image')->storeAs('aboutus', $file_name, 'public');
                        $content->content = $file_path;
                        $content->save();
                    }
                }else{
                    if ($content) {
                        $content->content = $item['content'];
                        $content->save();
                    }
                }
            }
    
            DB::commit();
            return response()->json(['message' => 'Aboutus created successfully'], 200);
        }catch(\Exception $e){
            DB::rollBack();
            $msg = $e->getMessage();
            return response()->json(['message' => 'Error creating aboutus', 
                                     'detail'  => $msg ], 500);
        }
    }

}