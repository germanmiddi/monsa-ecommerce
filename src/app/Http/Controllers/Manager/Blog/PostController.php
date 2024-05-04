<?php

namespace App\Http\Controllers\Manager\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    /**
     * Display a listing of the blog posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // TODO: Implement index method
        return Inertia::render('Manager/Blog/Index',[
            'posts'     => Post::orderBy('created_at', 'desc')
                                ->paginate(999)
                                ->withQueryString()
                                ->through(fn ($post) => [
                                        'id'          => $post->id,
                                        'post_category_id' => $post->post_category()->first()->name,
                                        'title'       => $post->title,
                                        'date_published' => $post->date_published,
                                        'post_status_id' => $post->postStatus()->first()->name,
                                        'content'   => $post->content,
                                        'image'     => $post->image,
                                        'slug'      => $post->slug,
                                        'created_at'  => $post->created_at->format('d-m-Y'),
                                ]),
            'toast' => Session::get('toast')
            ]);
    }

    /**
     * Show the form for creating a new blog post.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Manager/Blog/Create');        
    }

    /**
     * Store a newly created blog post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // TODO: Implement store method
        DB::beginTransaction();

        try{
            $post = new Post;
            $post->title       = $request->title;
            $post->slug        = $request->title;
            $post->content     = $request->content;
            
            $date_published = $request->date_published;
            $post->date_published   = date('Y-m-d', strtotime($date_published));            
            
            $post->author         = Auth::user()->name;
            $post->post_status_id = $request->post_status_id;
            $post->post_category_id    = $request->post_category_id;
            $post->post_user_id   = Auth::user()->id;
    
            if($request->file()) {
                $file_name = time().'_'.$request->file('image')->getClientOriginalName();
                $file_path = $request->file('image')->storeAs('blog', $file_name, 'public');
                $post->image = $file_path;
            }

            $post->save();
    
            DB::commit();
            //return redirect()->route('posts.list')->with('message', 'Creado con éxito')->setStatusCode(200);
            return response()->json(array('message' => 'Creado con éxito'), 200);
            
        }catch(\Exception $e){
            DB::rollback();
            $error = $e->getMessage();    
            return response()->json(array('message' => $error), 200);
        }
        


    }

    /**
     * Display the specified blog post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // TODO: Implement show method
    }

    /**
     * Show the form for editing the specified blog post.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Inertia::render('Manager/Blog/Edit', [
            'post' => Post::find($id)
        ]);
    }

    /**
     * Update the specified blog post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        DB::beginTransaction();
        try{
            $img_aux = $post->image;
            
            $date_published = $request->date_published;
            $request->date_published = date('Y-m-d', strtotime($date_published));//date('Y-m-d', strtotime(str_replace('/', '-', $date_published)));
            //dd($request->date_published);

            $post->update($request->all());
    
            if($request->input('imageChanged')){
    
                if (File::exists('storage/' . $img_aux)) {
                    if (File::delete('storage/' . $img_aux)){
                        $post->image = null;
                        $post->save(); 
                    }
                }
                
                if($request->file()) {
                    $file_name = time().'_'.$request->file('image')->getClientOriginalName();
                    $file_path = $request->file('image')->storeAs('blog', $file_name, 'public');
                    $post->image = $file_path;
                    $post->save();        
                }
            }
            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
            $error = $e->getMessage();
            dd($e);
            //return redirect()->route('posts.list')->with('message', 'Actualizado con éxito')->setStatusCode(500);
            return response()->json(array('message' => $error), 500);
        }
        // return Redirect::route('blog.index');
        return redirect()->route('posts.list')->with('message', 'Actualizado con éxito')->setStatusCode(200);
        //return response()->json(array('message' => 'Actualizado con éxito'), 200);
    }

    /**
     * Remove the specified blog post from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // TODO: Implement destroy method
    }
}
