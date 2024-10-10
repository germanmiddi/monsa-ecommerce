<?php

namespace App\Http\Controllers\Web\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Inertia\Inertia;
use App\Models\Messages;
use App\Models\Setting;
class ContactController extends Controller
{
    public function index()
    {
        return  Inertia::render('Web/Contact/Index');        
    }

    public function store(Request $request)
    {
        Messages::create($request->all());

        return response()->json(['message' => 'Mensaje enviado correctamente']);
    }
    public function getContactData()
    {
        
        $contact = Setting::where('module', 'contact')->get();
        
        return response()->json($contact);
    }

}
