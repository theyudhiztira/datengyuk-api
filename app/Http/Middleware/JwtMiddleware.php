<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{

/**
* Handle an incoming request.
*
* @param \Illuminate\Http\Request $request
* @param \Closure $next
* @return mixed
*/

    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                throw new Exception('User Not Found');
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return sendResponse([
                    'message' => 'Invalid token sent'
                ], 401);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return sendResponse([
                    'message' => 'Token expired'
                ], 401);
            } else {
                return sendResponse([
                    'message' => 'User not found'
                ], 401);

                return sendResponse([
                    'message' => 'No token provided'
                ], 400);
            }
        }

        return $next($request);
    }
}
