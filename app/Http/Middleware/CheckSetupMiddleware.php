<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSetupMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $setupCompleted = setupCompleted();

        if ($request->is('setup/*')) {
            if ($setupCompleted) {
                return to_route('home');
            }

            return $next($request);
        }

        if (! $setupCompleted) {
            return to_route('setup.welcome');
        }

        return $next($request);
    }
}
