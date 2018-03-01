<?php

namespace App\Http\Middleware\Api;

use App\Model\User;
use Carbon\Carbon;
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
            if (Carbon::parse($user->expires_at)->gt(Carbon::now())) {
                Auth::login($user);
                return $next($request);
            }

            throw new TokenMismatchException(__('api.error.session_expired'), Response::HTTP_UNAUTHORIZED);
        }

        throw new TokenMismatchException(__('api.error.token_not_found'), Response::HTTP_UNAUTHORIZED);
    }
}
