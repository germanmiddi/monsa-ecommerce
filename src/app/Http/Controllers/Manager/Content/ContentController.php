<?php

namespace App\Http\Controllers\Manager\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Slider;
use App\Models\ContentBrand;
use App\Models\ContentBanner;
use App\Models\Content;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        //$sliders = Slider::orderby('type')->get();
        return response()->json([
            'desktop'   => Slider::where('type','desktop')->get(),
            'mobile'    => Slider::where('type','mobile')->get()
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
            // DB::commit();
        }catch(\Exception $e){
            // DB::rollBack();
            $msg = $e->getMessage();
            return response()->json(['message' => 'Error deleting slider', 
            'detail'  => $msg ], 500);
        }
        
        return response()->json(['message' => 'Slider deleted'], 200);
    }

    public function brandList()
    {
        $brands = ContentBrand::all();
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
        /* try{
            $about = new ContentBrand();
            
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
        } */
    }

    // {
    //     $banner = ContentBanner::first();
    //     return response()->json($banner);
    // }
}