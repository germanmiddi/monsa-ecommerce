<?php

namespace App\Http\Controllers\Web\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    /**
     * Display the home page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // Add your logic here
        return  Inertia::render('Web/Index');
        
    }
    
    // Add more methods as needed
}
