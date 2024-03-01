<?php

namespace App\Http\Controllers\Manager\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContentController extends Controller
{
    public function index()
    {
        return Inertia::render('Manager/Content/Index');
    }
}