<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use app\Model\User;

class AdminLoginMiddleware
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
        if (Auth::Check()) {
            $user = Auth::user();
            if ($user->is_admin == User::ROLE_ADMIN) {
                return $next($request);
            }
            abort(403, trans("You don't have permission to access / on this server"));
        }
        return redirect('/login');
    }
}
