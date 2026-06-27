<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // We register the 'role' alias here so Laravel knows 
        // which class to use in your routes/web.php file.
        $middleware->alias([
            'role'            => \App\Http\Middleware\RoleMiddleware::class,
            'session.timeout' => \App\Http\Middleware\SessionTimeout::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Illuminate\Http\Exceptions\ThrottleRequestsException $e, $request) {
            if ($request->is('login') || $request->is('admin/login')) {
                $seconds = (int) $e->getHeaders()['Retry-After'] ?? 60;
                $minutes = ceil($seconds / 60);
                $msg = $minutes > 1
                    ? "Too many login attempts. Please wait {$minutes} minutes before trying again."
                    : "Too many login attempts. Please wait {$seconds} seconds before trying again.";
                return redirect()->route('login')->withErrors(['email' => $msg]);
            }
        });
    })->create();