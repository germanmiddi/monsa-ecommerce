<?php

namespace App\Http\Controllers\Manager\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    // public function index()
    // {
    //     $categories = Category::all();
    //     return view('manager.settings.category.index', compact('categories'));
    // }

    public function list()
    {
        $categories = Category::all();
        return response()->json($categories);
    }

    public function create()
    {
        return view('manager.settings.category.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $category = new Category();

            // Manejar la imagen si se sube una
            if($request->file('image')) {
                $file_name = time().'_'.$request->file('image')->getClientOriginalName();
                $file_path = $request->file('image')->storeAs('categories', $file_name, 'public');
                $category->image = $file_path;
            }

            $category->name = $request->name;
            $category->description = $request->description;
            $category->slug = $request->slug;
            $category->status = $request->status ?? 'active';
            $category->save();

            DB::commit();
            return response()->json(['message' => 'Category created successfully', 'category' => $category], 200);
        }catch(\Exception $e){
            DB::rollBack();
            $msg = $e->getMessage();
            return response()->json(['message' => 'Error creating category',
                                     'detail'  => $msg ], 500);
        }
    }

    public function update(Request $request, Category $category)
    {
        DB::beginTransaction();
        try{
            // Manejar la imagen si se sube una nueva
            if($request->file('image')) {
                // Eliminar la imagen anterior si existe
                if($category->image && Storage::disk('public')->exists($category->image)){
                    Storage::disk('public')->delete($category->image);
                }

                $file_name = time().'_'.$request->file('image')->getClientOriginalName();
                $file_path = $request->file('image')->storeAs('categories', $file_name, 'public');
                $category->image = $file_path;
            }

            $category->name = $request->name;
            $category->description = $request->description;
            $category->slug = $request->slug;
            $category->status = $request->status ?? $category->status;
            $category->save();

            DB::commit();
            return response()->json(['message' => 'Category updated successfully', 'category' => $category], 200);
        }catch(\Exception $e){
            DB::rollBack();
            $msg = $e->getMessage();
            return response()->json(['message' => 'Error updating category',
                                     'detail'  => $msg ], 500);
        }
    }

    public function destroy(Category $category)
    {
        try{
            // Borrar el archivo físico de la imagen si existe
            if($category->image && Storage::disk('public')->exists($category->image)){
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();
            return response()->json(['message' => 'Category deleted successfully'], 200);
        }catch(\Exception $e){
            $msg = $e->getMessage();
            return response()->json(['message' => 'Error deleting category',
                                   'detail'  => $msg ], 500);
        }
    }

    public function single($slug)
    {
        $category = Category::where('slug', $slug)->where('status', 'active')->first();

        if (!$category) {
            abort(404);
        }

        $products = $category->products()->get();

        return Inertia::render('Web/Category/Single', [
            'category' => $category,
            'products' => $products
        ]);
    }
}
