<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
   
    public function show()
    {
        return view('contact.show');
    }

   
     public function submit(Request $request)
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        
        $adminEmail = config('mail.from.address'); 

        Mail::to($adminEmail)->send(new ContactFormSubmitted($data));

        return back()->with('status', 'Thank you, your message has been sent.');
    }
}
