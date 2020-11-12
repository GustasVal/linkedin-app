<?php

namespace App\Http\Middleware;

use App\Models\Jwt;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AddSessionFromJwt
{

    public function handle(Request $request, Closure $next)
    {
        $sessionId = (new Jwt)->retrieveSessionId(\Illuminate\Support\Facades\Request::bearerToken());

        if (!$sessionId) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 401);
        }

        Session::setId($sessionId);

        return $next($request);
    }
}
