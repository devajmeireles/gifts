<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UnauthorizeSettingsPageAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        abort_if($request->user()->isGuest(), Response::HTTP_FORBIDDEN);

        return $next($request);
    }
}
