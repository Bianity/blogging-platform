<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfBanned
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
        if (setupCompleted()) {
            if (Auth::check() && Auth::user()->isBanned()) {
                $request->session()->flash('alert', __('This account is banned. For questions about unlocking you can write from Contact form!'));
                Auth::logout();

                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
