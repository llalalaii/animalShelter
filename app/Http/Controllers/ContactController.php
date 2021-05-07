<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('pages.contact.index');
    }

    public function list()
    {
        $contacts = Contact::all();
        return view('pages.contact.list', compact('contacts'));
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('pages.contact.show', compact('contact'));
    }

    public function destroy($id)
    {
        Contact::destroy($id);
        return redirect()->route('contact.list')->withSuccess('Message successfully deleted!');
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

        Mail::to(env('MAIL_TO_ADDRESS'))->send(new ContactMail($contact));

        return redirect()->back()->withSuccess('Your message has been submitted.');
    }
}
