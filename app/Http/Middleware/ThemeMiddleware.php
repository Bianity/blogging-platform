<?php

namespace App\Http\Middleware;

use App\Managers\Theme\Theme;
use Closure;
use Illuminate\Http\Request;

class ThemeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $theme, string $parentTheme = null)
    {
        Theme::set($theme, $parentTheme);

        return $next($request);
    }
}
