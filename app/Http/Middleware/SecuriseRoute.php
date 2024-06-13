<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecuriseRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si l'utilisateur essaie d'accéder à une route sécurisée sans jeton, renvoyez une réponse non autorisée
        if (!$request->bearerToken()) {
            return response()->json([
                'error' => 'Unauthorized',
                'status' => 401,
                'detail' => 'Invalid acces token',
            ], 401);
        }

        return $next($request);
    }
}
