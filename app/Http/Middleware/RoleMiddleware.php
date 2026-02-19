<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role, ?string $guard = null): Response
    {
        $auth = auth()->guard($guard);

        if (!$auth->check()) {
            // Redirect based on guard if possible, or default
            if ($guard === 'admin') {
                return redirect()->route('admin.login');
            }
            return redirect('/login');
        }

        if (!$auth->user()->hasRole($role, $guard)) {
             abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}
