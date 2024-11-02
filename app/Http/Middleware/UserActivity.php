<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserActivity
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
        if (Auth::check()) {
            $expire = Carbon::now()->addSeconds(120);

            Cache::remember('is-online-'.getCurrentUser()->id, $expire, function () {
                $user = User::where('id', getCurrentUser()->id)->first();
                $user->timestamps = false;
                $user->last_seen = now();
                $user->save();

                return $user;
            });
        }

        return $next($request);
    }
}
