<?php

use App\Http\Middleware\EnsureUserIsAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Nginx terminates TLS and forwards X-Forwarded-Proto; trust it so
        // generated URLs and redirects use https instead of http. Production
        // runs in Docker, where the request arrives from the bridge gateway
        // inside 172.16.0.0/12 rather than from loopback. The callback runs
        // before the config repository is bound, so these stay literal.
        $middleware->trustProxies(
            at: ['127.0.0.1', '::1', '172.16.0.0/12'],
            headers: Request::HEADER_X_FORWARDED_FOR
                | Request::HEADER_X_FORWARDED_HOST
                | Request::HEADER_X_FORWARDED_PORT
                | Request::HEADER_X_FORWARDED_PROTO,
        );

        $middleware->alias([
            'role.auth' => EnsureUserIsAuthenticated::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
