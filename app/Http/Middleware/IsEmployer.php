<?php

namespace App\Http\Middleware;

use Closure;

class IsEmployer
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
        if($user->profileType != 2){
            abort(401);
        }
        return $next($request);
    }
}
