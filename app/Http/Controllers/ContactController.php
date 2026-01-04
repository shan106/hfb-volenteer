<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\ContactMessage;

class ContactController extends Controller
{
   
    public function show()
    {
        return view('contact.show');
    }

   
     public function submit(Request $request)
    {
       $data = $request->validate([
        'name' => ['nullable','string','max:255'],
        'email' => ['required','email','max:255'],
        'subject' => ['nullable','string','max:255'],
        'message' => ['required','string','max:5000'],
    ]);

    ContactMessage::create([
        'user_id' => auth()->id(),
        'name' => $data['name'] ?? null,
        'email' => $data['email'],
        'subject' => $data['subject'] ?? null,
        'message' => $data['message'],
    ]);

   
    try {
        $adminEmail = config('mail.from.address');
        Mail::to($adminEmail)->send(new \App\Mail\ContactFormSubmitted($data));
    } catch (\Throwable $e) {
        
        \Log::error('Contact mail failed: ' . $e->getMessage());
    }

    return back()->with('status', 'Thank you, your message has been sent.');

        }
}
