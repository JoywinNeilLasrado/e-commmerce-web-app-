<?php

namespace App\Http\Controllers;

use App\Models\SupportPage;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function warranty(Request $request)
    {
        $page = SupportPage::findBySlug('warranty');
        abort_if(!$page, 404);

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json(['success' => true, 'page' => $page]);
        }

        return view('support.warranty', compact('page'));
    }

    public function returns(Request $request)
    {
        $page = SupportPage::findBySlug('returns');
        abort_if(!$page, 404);

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json(['success' => true, 'page' => $page]);
        }

        return view('support.returns', compact('page'));
    }

    public function shipping(Request $request)
    {
        $page = SupportPage::findBySlug('shipping');
        abort_if(!$page, 404);

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json(['success' => true, 'page' => $page]);
        }

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

            if ($request->routeIs('api.*') || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you! We\'ve received your message and will get back to you within 24 hours.'
                ]);
            }

            return back()->with('contact_success', 'Thank you! We\'ve received your message and will get back to you within 24 hours.');
        }

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json(['success' => true, 'page' => $page]);
        }

        return view('support.contact', compact('page'));
    }
}
