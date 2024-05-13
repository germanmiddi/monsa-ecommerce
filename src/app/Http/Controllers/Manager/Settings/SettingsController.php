<?php

namespace App\Http\Controllers\Manager\Settings;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Carbon\Carbon;
use App\Models\Family;
use App\Models\Label;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){
        return Inertia::render('Manager/Settings/Index');

    }

    public function familyList(){

        return Family::all();

    }

    public function familyUpdate(Family $family){
        try{
            $family->active = !$family->active;
            $family->save();
            return response()->json(['message' => 'Familia actualizada correctamente']);
        }catch(\Exception $e){
            $msg = $e->getMessage();
            return response()->json(['message' => 'Error al actualizar la familia', 'error'=> $msg ], 500);
        }
    }

    public function brandList(){
        return Brand::all();
    }

    public function brandUpdate(Brand $label){

        try{
            $label->active = !$label->active;
            $label->save();
            return response()->json(['message' => 'Etiqueta actualizada correctamente']);
        }catch(\Exception $e){
            $msg = $e->getMessage();
            return response()->json(['message' => 'Error al actualizar la Etiqueta', 'error'=> $msg ], 500);
        }

    }

    public function labelList(){
        return Label::all();
    }

    public function labelStore(Request $request){
        try{
            // Convertir el texto a ASCII
            $ascii_text = Str::ascii($request->nombre);
            // Generar el slug a partir del texto ASCII
            $slug = Str::slug($ascii_text);

            $label = Label::create([
                'nombre' => $request->nombre,
                'slug' => $slug,
            ]);
            return response()->json(['message' => 'Etiqueta creada correctamente'],200);
        }catch(\Exception $e){
            $msg = $e->getMessage();
            return response()->json(['message' => 'Error al crear la Etiqueta', 'error'=> $msg ], 500);
        }
    }

    public function labelUpdate(Label $label){
        try{
            $label->active = !$label->active;
            $label->save();
            return response()->json(['message' => 'Etiqueta actualizada correctamente'],200);
        }catch(\Exception $e){
            $msg = $e->getMessage();
            return response()->json(['message' => 'Error al actualizar la Etiqueta', 'error'=> $msg ], 500);
        }
    }

    
}
