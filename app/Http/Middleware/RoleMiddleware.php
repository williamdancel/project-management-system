<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        // If User.role is an Enum (cast), normalize to string value
        $userRole = $user->role?->value ?? $user->role;

        // Normalize incoming roles (allow enums or strings)
        $allowedRoles = array_map(
            fn ($role) => is_object($role) && property_exists($role, 'value') ? $role->value : $role,
            $roles
        );

        if (! in_array($userRole, $allowedRoles, true)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
