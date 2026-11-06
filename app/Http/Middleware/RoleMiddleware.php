<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\AuthService;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        $auth = app(AuthService::class);

        $header = $request->header('Authorization');
        if (!$header || !str_starts_with($header, 'Bearer ')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = substr($header, 7);
        $decoded = $auth->verifyToken($token);

        // Kalau token invalid
        if (!$decoded) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Cek role
        if (($decoded->role ?? 'user') !== $role) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
