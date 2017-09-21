<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;

class AuthenticatedForWeb
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
        if (! Visitor::user()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(route('web.login'));
            }
        }
        return $next($request);
    }
}
