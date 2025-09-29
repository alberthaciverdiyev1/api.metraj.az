<?php

namespace Modules\Contact\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Contact\Models\Contact;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|required_without:phone',
            'phone' => 'nullable|string|required_without:email',
            'message' => 'required|string',
        ]);

        $contact = Contact::create($data);

        return response()->json($contact, 201);
    }

    public function index()
    {
        $contacts = Contact::orderByDesc('created_at')->get();
        return response()->json($contacts);
    }
}
