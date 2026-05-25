<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user() && ($request->user()->role == 'admin')) {
            return $next($request);
        } else {
            return ApiResponse::error(
                null, 
                'You do not have permission to perform this action', 
                403
            );
        }
    }
}
