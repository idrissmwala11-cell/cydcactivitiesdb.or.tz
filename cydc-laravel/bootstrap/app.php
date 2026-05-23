<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'user.status' => \App\Http\Middleware\UserStatusMiddleware::class,
        ]);
        
        // Apply user status middleware to web routes
        $middleware->web(append: [
            \App\Http\Middleware\UserStatusMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->create();

// Serve assets and the Vite manifest from the project root instead of the default "public" directory
$app->usePublicPath(dirname(__DIR__));

return $app;
