<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function warranty()
    {
        return view('support.warranty');
    }

    public function returns()
    {
        return view('support.returns');
    }

    public function shipping()
    {
        return view('support.shipping');
    }

    public function contact(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'name'    => ['required', 'string', 'max:255'],
                'email'   => ['required', 'email', 'max:255'],
                'subject' => ['required', 'string', 'max:255'],
                'message' => ['required', 'string', 'max:3000'],
            ]);

            // Flash success — in production you'd send an email here
            return back()->with('contact_success', 'Thank you! We\'ve received your message and will get back to you within 24 hours.');
        }

        return view('support.contact');
    }
}
