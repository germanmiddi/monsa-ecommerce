<?php

namespace App\Http\Controllers\Web\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function single($slug)
    {

        return Inertia::render('Web/Pages/Single',[
            'page' => Page::where('slug', $slug)->first()
        ]);
    }

    public function list()
    {
        $pages = Page::all();
        return response()->json($pages);
    }

    public function create()
    {
        return Inertia::render('Manager/Content/Pages/Create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $page = new Page();
            $page->title = $request->title;
            $page->slug = $request->title;
            $page->content = $request->content; 
            $page->author = Auth::user()->name;
            $page->save();

            DB::commit();
            return response()->json(array('message' => 'Creado con éxito'), 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(array('message' => $e->getMessage()), 200);
        }

    }

    public function edit($id)
    {
        $page = Page::find($id);
        return response()->json($page);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        try{
            $page = Page::find($request->id);
            $page->title = $request->title;
            $page->slug = $request->title;
            $page->content = $request->content; 
            $page->author = Auth::user()->name;
            $page->save();

            DB::commit();
            return response()->json(array('message' => 'Actualizado con éxito'), 200);
        }catch(\Exception $e){
            DB::rollback();
            return response()->json(array('message' => $e->getMessage()), 200);
        }
    }

}
