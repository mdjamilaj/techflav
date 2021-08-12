<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $data = Contact::latest()->paginate(10);
        return view('contact.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function show($id)
    {
        $data = Contact::find($id);
        return view('contact.show', compact('data'));
    }


}
