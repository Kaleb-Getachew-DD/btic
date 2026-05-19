<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\StoreContactRequest;
use App\Models\Notification;

class ContactController extends Controller
{
    public function index()
    {
        return view('web.contact.index');
    }

    public function send(StoreContactRequest $request)
    {
        $data = $request->validated();

        Notification::notifyAdmins(
            'new_message',
            'New Contact Message from ' . $data['name'],
            $data['message'],
            ['email' => $data['email'], 'phone' => $data['phone'] ?? null, 'subject' => $data['subject']],
            route('admin.notifications.index')
        );

        return back()->with('success', 'Your message has been sent. We will get back to you shortly!');
    }
}
