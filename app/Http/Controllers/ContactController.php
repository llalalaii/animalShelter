<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact.index');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'subject' => 'required|max:255',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required',
        ], [
            'subject.required' => 'Subject is required.',
            'subject.max' => 'Maximum length is 255 characters.',
            'name.required' => 'Name is required.',
            'name.max' => 'Maximum length is 255 characters.',
            'email.required' => 'Email is required.',
            'email.max' => 'Maximum length is 255 characters.',
            'message.required' => 'Message is required.',
        ]);

        $contact = new Contact();
        $contact->subject = $request->subject;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->save();

        return redirect()->back()->withSuccess('Your message has been submitted.');
    }
}
