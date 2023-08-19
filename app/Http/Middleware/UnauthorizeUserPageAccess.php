<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UnauthorizeUserPageAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_if(!$request->user()->isAdmin(), Response::HTTP_FORBIDDEN);

        return $next($request);
    }
}
