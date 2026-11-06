<?php

namespace App\Http\Middleware;

use Closure;

class UserSession
{
    public function handle($request, Closure $next)
    {
        if (!session('nexa_logged_in')) {
            return redirect('/login');
        }
        return $next($request);
    }
}
