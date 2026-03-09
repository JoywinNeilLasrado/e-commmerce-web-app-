<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'nullable|string|max:255',
            'full_name' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $user = Auth::user();
        
        // If this is the first address, make it default
        $isDefault = $user->addresses()->count() === 0;

        $user->addresses()->create(array_merge($validated, ['is_default' => $isDefault]));

        if ($request->routeIs('api.*') || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Address added successfully.',
                'address' => $user->addresses()->latest()->first() // or assign to $address above
            ]);
        }

        return back()->with('success', 'Address added successfully.');
    }
}
