<?php

namespace App\Http\Controllers\Manager\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Content;

class MarketingController extends Controller
{
    public function index()
    {
        $content = Content::where('page', 'marketing')
            ->where('section', 'popup')
            ->get();


        return inertia('Manager/Marketing/Index', [
            'link' => $content->where('element', 'link')->first()?->content,
            'image' => $content->where('element', 'img')->first()?->content,
            'active' => $content->where('element', 'active')->first()?->content,
        ]);
    }

    public function getContent($page, $section)
    {
        $content = Content::where('page', $page)->where('section', $section)->first();
        return response()->json($content);
    }

    public function storeImage(Request $request)
    {

        dd($request->all());
        // $content = Content::where('page', 'marketing')


        $image = $request->file('image');
        $image->storeAs('public/marketing', $image->hashName());
        return response()->json(['message' => 'Image uploaded successfully']);
    }

    public function updateContent(Request $request)
    {

        $image = null;
        if($request->file()) {
            $file_name = time().'_'.$request->file('image')->getClientOriginalName();
            $file_path = $request->file('image')->storeAs('marketing', $file_name, 'public');
            $image = $file_path;
        }

        // Update link content
        Content::where('page', 'marketing')
            ->where('section', 'popup')
            ->where('element', 'link')
            ->update(['content' => $request->link]);

        // Update active content
        Content::where('page', 'marketing')
            ->where('section', 'popup')
            ->where('element', 'active')
            ->update(['content' => $request->active]);

        // Update image content
        Content::where('page', 'marketing')
            ->where('section', 'popup')
            ->where('element', 'img')
            ->update(['content' => $image]);

        return response()->json(['message' => 'Content updated successfully']);
    }


}
