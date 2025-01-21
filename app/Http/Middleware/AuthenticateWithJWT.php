<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateWithJWT
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $jwt = $request->cookie('jwt');

        if (!$jwt) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        try {
            $key = env('JWT_SECRET');
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
            $request->attributes->add(['user_id' => $decoded->sub]);
            return $next($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }
    }
}
