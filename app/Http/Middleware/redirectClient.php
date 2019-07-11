<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class redirectClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user->client_id != null) {
            return redirect('/home');
        }

        return $next($request);
    }
}
