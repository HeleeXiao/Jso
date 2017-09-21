<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;

class RedirectIfAuthenticatedForWeb
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Visitor::user()) {
            return redirect()->intended();
        }

        return $next($request);
    }
}
