<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Admin
{
    /**
        * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (Auth::user()->type != 'admin') {
            return redirect('/');
        }

        return $next($request);
    }
}
