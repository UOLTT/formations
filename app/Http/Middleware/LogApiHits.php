<?php

namespace App\Http\Middleware;

use App\ApiHit;
use Closure;

class LogApiHits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        ApiHit::create([
            'user_id' => (!is_null(\Auth::user()) ? \Audh::user()->id : 0),
            'organization_id' => (!is_null(\Auth::user()) ? \Auth::user()->organization_id : 0),
            'path' => $request->route()->getUri(),
            'query_data' => serialize($request->all())
        ]);
        return $next($request);
    }
}
