<?php

namespace App\Http\Controllers\Web\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        return  Inertia::render('Web/Contact/Index');        
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required',
    //         'email' => 'required|email',
    //         'message' => 'required',
    //     ]);

    //     Contact::create($request->all());

    //     return redirect()->route('contacto')->with('success', 'Mensaje enviado correctamente');
    // }
}
