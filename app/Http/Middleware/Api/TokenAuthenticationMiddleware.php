<?php

namespace App\Http\Middleware\Api;

use App\Model\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Session\TokenMismatchException;
use Closure;

class TokenAuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request request
     * @param \Closure                 $next    next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $accessToken = $request->headers->get('access-token');

        $user = $accessToken ? User::where('access_token', $accessToken)->first() : null;

        if ($user) {
            Auth::login($user);
            return $next($request);
        }

        throw new TokenMismatchException(__('api.error.unauthorized'), Response::HTTP_UNAUTHORIZED);
    }
}
