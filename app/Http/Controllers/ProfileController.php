<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = auth()->user()->load('addresses');

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json([
                'user' => $user
            ]);
        }

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(auth()->id())],
        ]);

        auth()->user()->update($validated);

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json([
                'message' => 'Profile updated successfully.',
                'user' => auth()->user()
            ]);
        }

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json([
                'message' => 'Password updated successfully.',
                'user' => auth()->user()
            ]);
        }

        return back()->with('success', 'Password updated successfully.');
    }

    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'label' => ['nullable', 'string', 'max:255'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:255'],
            'is_default' => ['sometimes', 'boolean'],
        ]);

        // If this is the first address or marked as default, unset other defaults
        $isDefault = auth()->user()->addresses()->count() === 0 || $request->has('is_default');
        
        if ($isDefault) {
            auth()->user()->addresses()->update(['is_default' => false]);
            $validated['is_default'] = true;
        } else {
            $validated['is_default'] = false;
        }

        $address = auth()->user()->addresses()->create($validated);

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json([
                'message' => 'Address added successfully.',
                'address' => $address
            ]);
        }

        return back()->with('success', 'Address added successfully.');
    }

    public function updateAddress(Request $request, Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            if ($request->routeIs('api.*') || $request->wantsJson()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            abort(403);
        }

        $validated = $request->validate([
            'label' => ['nullable', 'string', 'max:255'],
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:255'],
            'is_default' => ['sometimes', 'boolean'],
        ]);

        if ($request->has('is_default') && $request->is_default) {
            auth()->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
            $validated['is_default'] = true;
        }

        $address->update($validated);

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json([
                'message' => 'Address updated successfully.',
                'address' => $address
            ]);
        }

        return back()->with('success', 'Address updated successfully.');
    }

    public function destroyAddress(Address $address)
    {
        if ($address->user_id !== auth()->id()) {
            if (request()->routeIs('api.*') || request()->wantsJson()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            abort(403);
        }

        $address->delete();

        // If deleted address was default, set another as default
        if ($address->is_default) {
            $newDefault = auth()->user()->addresses()->first();
            if ($newDefault) {
                $newDefault->update(['is_default' => true]);
            }
        }

        if (request()->routeIs('api.*') || request()->wantsJson()) {
            return response()->json(['message' => 'Address deleted successfully.']);
        }

        return back()->with('success', 'Address deleted successfully.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required'],
        ]);

        if (!Hash::check($request->password, $request->user()->password)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => 'Incorrect password. Please try again.',
                ], 422);
            }

            return back()
                ->withErrors(['delete_password' => 'Incorrect password. Please try again.'])
                ->with('delete_attempted', true);
        }

        $user = $request->user();

        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['redirect' => url('/')]);
        }

        return redirect('/')->with('status', "Your account has been permanently deleted. We're sorry to see you go!");
    }
}
