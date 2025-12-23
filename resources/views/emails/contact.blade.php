@component('mail::message')
# New contact message

You have received a new contact form submission.

**Name:** {{ $data['name'] }}  
**Email:** {{ $data['email'] }}  
**Subject:** {{ $data['subject'] }}

---

{{ $data['message'] }}

@endcomponent
