<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            // Redirect based on role
            if (Auth::user()->hasRole('admin')) {
                return redirect()->intended('/admin');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(),
            'role' => 'customer',
        ]);

        // Assign customer role
        $user->assignRole('customer');

        // Create cart for user
        Cart::create(['user_id' => $user->id]);

        Auth::login($user);

        return redirect('/')->with('success', 'Welcome to Refurbished Phones Shop!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // ----------------------------------------------------------------------
    // API ONLY METHODS FOR POSTMAN TESTING
    // ----------------------------------------------------------------------

    public function apiLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json([
                'message' => 'The provided credentials do not match our records.'
            ], 401);
        }

        return $this->respondWithToken($token, 'Login successful via API');
    }

    public function apiRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(),
            'role' => 'customer',
        ]);

        $user->assignRole('customer');
        Cart::create(['user_id' => $user->id]);

        $token = auth('api')->login($user);

        return $this->respondWithToken($token, 'User created successfully via API', 201);
    }

    public function apiLogout(Request $request)
    {
        auth('api')->logout();
        
        return response()->json([
            'message' => 'Logged out successfully via API'
        ], 200);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     * @param  string $message
     * @param  int $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $message = 'Success', $status = 200)
    {
        return response()->json([
            'message' => $message,
            'user' => auth('api')->user(),
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ], $status);
    }
}
