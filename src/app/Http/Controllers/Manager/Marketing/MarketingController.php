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
            'content' => $content
        ]);
    }

    public function getContent($page, $section)
    {
        $content = Content::where('page', $page)->where('section', $section)->first();
        return response()->json($content);
    }

    public function storeImage(Request $request)
    {
        $image = $request->file('image');
        $image->storeAs('public/marketing', $image->hashName());
        return response()->json(['message' => 'Image uploaded successfully']);
    }


}
