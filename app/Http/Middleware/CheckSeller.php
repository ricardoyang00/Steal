<?php

namespace App\Http\Middleware;

use Closure;

class CheckSeller
{
    public function handle($request, Closure $next)
    {
        if (auth_user() && auth_user()->seller()) {
            return $next($request);
        }

        abort(404);
    }
}