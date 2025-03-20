<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = env('BASIC_AUTH_USER');
        $pass = env('BASIC_AUTH_PASS');

        if ($request->getUser() !== $user || $request->getPassword() !== $pass) {
            $headers = ['WWW-Authenticate' => 'Basic'];
            return response('Invalid credentials.', 401, $headers);
        }

        return $next($request);
    }
}
