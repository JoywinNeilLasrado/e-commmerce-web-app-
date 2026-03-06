<?php

namespace App\Http\Controllers;

use App\Models\SupportPage;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function warranty()
    {
        $page = SupportPage::findBySlug('warranty');
        abort_if(!$page, 404);
        return view('support.warranty', compact('page'));
    }

    public function returns()
    {
        $page = SupportPage::findBySlug('returns');
        abort_if(!$page, 404);
        return view('support.returns', compact('page'));
    }

    public function shipping()
    {
        $page = SupportPage::findBySlug('shipping');
        abort_if(!$page, 404);
        return view('support.shipping', compact('page'));
    }

    public function contact(Request $request)
    {
        $page = SupportPage::findBySlug('contact');
        abort_if(!$page, 404);

        if ($request->isMethod('post')) {
            $request->validate([
                'name'    => ['required', 'string', 'max:255'],
                'email'   => ['required', 'email', 'max:255'],
                'subject' => ['required', 'string', 'max:255'],
                'message' => ['required', 'string', 'max:3000'],
            ]);

            return back()->with('contact_success', 'Thank you! We\'ve received your message and will get back to you within 24 hours.');
        }

        return view('support.contact', compact('page'));
    }
}
