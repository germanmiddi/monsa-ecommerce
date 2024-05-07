<?php

namespace App\Http\Controllers\Web\Aboutus;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AboutusController extends Controller
{
    public function index()
    {
        //return Inertia::render('Web/About/Index');
        return  Inertia::render('Web/About/Index', [
            'content' => Content::where('page', 'aboutus')->get()
        ]);
    }
}
