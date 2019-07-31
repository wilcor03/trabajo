<?php

namespace App\Http\Middleware;

use Closure;

class IsEmployee
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
        $user = $request->user();
        if($user->profileType != 3){
            abort(401);
        }
        return $next($request);
    }
}
