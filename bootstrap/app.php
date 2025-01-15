<?php

use App\Http\Middleware\AppCheckInstalledMiddleware;
use Illuminate\Foundation\Application;
use App\Http\Middleware\TwoFactorVerifyMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies('*');
        $middleware->web(append: [
            AppCheckInstalledMiddleware::class,
            \App\Http\Middleware\HandleInertiaRequests::class,
            \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
            \App\Http\Middleware\RedirectIfUserSuspended::class,
            \App\Http\Middleware\RegistrationDisableMiddleware::class,
        ]);
        $middleware->alias([
            '2fa.verify' => TwoFactorVerifyMiddleware::class,
            'registration.disable' => \App\Http\Middleware\RegistrationDisableMiddleware::class,
            'installer' => AppCheckInstalledMiddleware::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
