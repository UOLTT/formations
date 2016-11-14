<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class ApiAuthentication
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
        if (!\Auth::user() && !$request->isMethod('get') && $request->has('token')) {
            $token = $request->get('token');
            $User = User::whereHas('devices',function($query) use ($token) {
                $query->where('token',$token);
                $query->where('used','!=',0);
            })->first();
            if (!is_null($User)) {
                \Auth::login($User);
            }
        }
        return $next($request);
    }
}
