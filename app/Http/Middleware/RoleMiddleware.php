<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        if (! method_exists($request->user(), 'hasRole') || ! $request->user()->hasRole($role)) {
            return response()->json([
                'status' => 'failure',
                'message' => 'Unauthorized access',
                'date' => null,
        ], 401);
        }

        return $next($request);
    }
}
