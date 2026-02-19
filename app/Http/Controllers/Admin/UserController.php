<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load(['roles', 'addresses', 'orders.items.productVariant.product']);
        return view('admin.users.show', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Only allow updating roles for now
        $validated = $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        // Prevent admin from removing their own admin role
        if ($user->id === auth()->id() && $user->hasRole('admin') && $validated['role'] !== 'admin') {
            return back()->with('error', 'You cannot remove your own admin privileges.');
        }

        $user->syncRoles([$validated['role']]);
        $user->update(['role' => $validated['role']]);

        return back()->with('success', 'User role updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
