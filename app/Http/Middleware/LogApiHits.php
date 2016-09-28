<?php

namespace App\Http\Middleware;

use App\ApiHit;
use Closure;

class LogApiHits
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
        if (Auth::user()) {
            ApiHit::create([
                'user_id' => Auth::user()->id,
                'organization_id' => Auth::user()->organization_id,
                'path' => $request->route()->getUri(),
                'query_data' => serialize($request->all())
            ]);
        }
        return $next($request);
    }
}
