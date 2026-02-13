<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiRequestLog;

class ApiRequestLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        ApiRequestLog::create([
            'user_id' => $request->user()?->id,
            'method' => $request->method(),
            'endpoint' => '/'.$request->path(),
            'status_code' => $response->getStatusCode(),
            'requested_at' => now(),
        ]);

        return $response;
    }
}
