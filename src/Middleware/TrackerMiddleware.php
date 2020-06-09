<?php

declare (strict_types = 1);

namespace Task\Tracker\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrackerMiddleware
{
    /**
     * Run the request filter.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
