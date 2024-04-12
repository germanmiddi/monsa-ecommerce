<?php

namespace App\Http\Controllers\Manager\Settings;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Carbon\Carbon;
use App\Models\Family;

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

    public function brandUpdate(Brand $brand){

        try{
            $brand->active = !$brand->active;
            $brand->save();
            return response()->json(['message' => 'Marca actualizada correctamente']);
        }catch(\Exception $e){
            $msg = $e->getMessage();
            return response()->json(['message' => 'Error al actualizar la marca', 'error'=> $msg ], 500);
        }

    }

    
}
