<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    
    public function __construct(array $data)
    {
       
        $this->data = $data;
    }

    public function build()
    {
        return $this
            ->subject('New contact message: ' . ($this->data['subject'] ?? 'Contact form'))
            ->markdown('emails.contact')  
            ->with([
                'data' => $this->data,
            ]);
    }
}
