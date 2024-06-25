<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustProxies::class,
        // \App\Http\Middleware\CheckForMaintenanceMode::class, // Middleware ini tidak didefinisikan
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        // \App\Http\Middleware\TrimStrings::class, // Middleware ini tidak didefinisikan
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            // \App\Http\Middleware\EncryptCookies::class, // Middleware ini tidak didefinisikan
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // \App\Http\Middleware\VerifyCsrfToken::class, // Middleware ini tidak didefinisikan
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\CorrectUrlMiddleware::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],
    ];

    /**
     * The priority-sorted list of middleware.
     *
     * This forces non-global middleware to always be in the given order.
     *
     * @var array
     */
    protected $middlewarePriority = [
        // \Illuminate\Foundation\Http\Middleware\HandleCors::class, // Middleware ini tidak didefinisikan
        \Illuminate\Auth\Middleware\Authenticate::class,
        \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        // \Illuminate\Cookie\Middleware\EncryptCookies::class, // Middleware ini tidak didefinisikan
        // \Illuminate\Foundation\Http\Middleware\ForbidBannedUserFromAccessingRoute::class, // Middleware ini tidak didefinisikan
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        // \App\Http\Middleware\TrimStrings::class, // Middleware ini tidak didefinisikan
    ];
}
