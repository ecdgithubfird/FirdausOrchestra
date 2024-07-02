<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ContactForm;

class ContactFormController extends Controller
{
    //
    public function store(Request $request)
    {
        $rules = [
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'company' => 'nullable|string|max:255',
            'contact_no' => 'nullable|regex:/^\d{10}$/',
            'country' => 'nullable|string|max:255',
            'inquiry' => 'nullable|string|max:2000',
        ];
    
        // Create validator instance
        $validator = Validator::make($request->all(), $rules);
    
        // Check if validation fails
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        // Create the contact form entry on successful validation
        ContactForm::create($validator->validated());
    
        // Flash a success message to the session
        return back()->with('success', 'Message sent successfully!');
    }
}
