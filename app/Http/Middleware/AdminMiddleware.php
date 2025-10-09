<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        $isAdmin = $user && (
            (method_exists($user, 'isAdmin') && $user->isAdmin()) ||
            (($user->role ?? null) === 'admin')
        );

        if (!$isAdmin) {
            // JSON callers still get a proper 403
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            // Web: go home
            return redirect('/');
        }

        return $next($request);
    }
}
