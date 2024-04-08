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

    }

    public function brandList(){
        return Brand::all();
    }

    public function brandUpdate(Brand $brand){

    }

    
}
