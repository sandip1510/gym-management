<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Check if user has any of the allowed roles
        if (! $user->hasAnyRole($roles)) {
            return response()->json(['message' => 'Forbidden - insufficient role'], 403);
        }

        return $next($request);
    }
}
