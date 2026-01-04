<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status'); 

        $messages = ContactMessage::query()
            ->when($status === 'open', fn($q) => $q->where('is_replied', false))
            ->when($status === 'replied', fn($q) => $q->where('is_replied', true))
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.contact-messages.index', compact('messages', 'status'));
    }

    public function show(ContactMessage $contactMessage)
    {
        return view('admin.contact-messages.show', compact('contactMessage'));
    }

    public function reply(Request $request, ContactMessage $contactMessage)
    {
        $data = $request->validate([
            'reply_subject' => ['required', 'string', 'max:255'],
            'reply_message' => ['required', 'string', 'max:5000'],
        ]);

        
        Mail::raw($data['reply_message'], function ($m) use ($contactMessage, $data) {
            $m->to($contactMessage->email)
              ->subject($data['reply_subject']);
        });

        $contactMessage->update([
            'is_replied' => true,
            'replied_at' => now(),
            'replied_by' => auth()->user()->email,
        ]);

        return redirect()
            ->route('admin.contact-messages.show', $contactMessage)
            ->with('status', 'Reply sent and message marked as replied.');
    }
}
