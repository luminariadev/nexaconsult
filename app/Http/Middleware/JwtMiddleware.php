<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\AuthService;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');

        // ======================================================
        // Jika tidak ada token sama sekali
        // ======================================================
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {

            // Jika request ke API → balas JSON 401
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token missing'
                ], 401);
            }

            // Jika request web → redirect ke /login
            return redirect('/login');
        }

        $token = substr($authHeader, 7);

        // ======================================================
        // Validasi token via AuthService
        // ======================================================
        $decoded = app(AuthService::class)->verifyToken($token);

        if (!$decoded) {
            // Jika API → JSON
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token invalid or expired'
                ], 401);
            }

            // Jika web → redirect login
            return redirect('/login');
        }

        // ======================================================
        // Token valid → lanjutkan request
        // ======================================================
        return $next($request);
    }
}
