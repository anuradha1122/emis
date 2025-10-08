<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $permission
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, "Unauthorized");
        }

        // Check if user has permission
        if (!$user->hasPermission($permission)) {
            abort(403, "You don't have permission to access this route.");
        }

        return $next($request);
    }
}

