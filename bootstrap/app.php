<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web:      __DIR__.'/../routes/web.php',
        api:      __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health:   '/up',
        apiPrefix: 'api',
    )
    // The /broadcasting/auth endpoint must accept Sanctum tokens, so register
    // the broadcast routes explicitly with the auth:sanctum middleware. This
    // also loads channel authorization callbacks from routes/channels.php.
    ->withBroadcasting(
        __DIR__.'/../routes/channels.php',
        ['prefix' => 'api', 'middleware' => ['auth:sanctum']],
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Enables Sanctum cookie-based auth for first-party SPA clients while
        // still allowing token-based auth for everyone else.
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Always render JSON errors for /api/* (validation, 401, 403, 404, etc.)
        $exceptions->shouldRenderJsonWhen(function ($request, $e) {
            return $request->is('api/*') || $request->expectsJson();
        });
    })->create();
