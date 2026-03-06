<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportPage;
use Illuminate\Http\Request;

class SupportPageController extends Controller
{
    public function index()
    {
        $pages = SupportPage::orderBy('id')->get();
        return view('admin.support.index', compact('pages'));
    }

    public function edit(SupportPage $supportPage)
    {
        return view('admin.support.edit', compact('supportPage'));
    }

    public function update(Request $request, SupportPage $supportPage)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'content'          => ['required', 'string'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'is_active'        => ['sometimes', 'boolean'],
        ]);

        $validated['is_active'] = $request->boolean('is_active');
        $supportPage->update($validated);

        return redirect()->route('admin.support.index')
            ->with('success', '"' . $supportPage->title . '" page updated successfully.');
    }

    public function toggle(SupportPage $supportPage)
    {
        $supportPage->update(['is_active' => !$supportPage->is_active]);

        $status = $supportPage->is_active ? 'activated' : 'deactivated';
        return back()->with('success', '"' . $supportPage->title . '" page ' . $status . '.');
    }
}
