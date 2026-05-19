<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'admin.guard' => \App\Http\Middleware\UseAdminGuard::class,
            'prevent.cache' => \App\Http\Middleware\PreventBrowserCache::class,
        ]);

        $middleware->redirectUsersTo(function (Request $request) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.dashboard');
            }

            return route('home');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response, \Throwable $e, Request $request) {
            if ($request->expectsJson()) {
                return $response;
            }

            $status = $response->getStatusCode();

            if ($status >= 400 && view()->exists("errors.$status")) {
                return response()->view("errors.$status", [
                    'exception' => $e,
                ], $status);
            }

            if ($status >= 400 && $status < 500 && view()->exists('errors.4xx')) {
                return response()->view('errors.4xx', [
                    'exception' => $e,
                ], $status);
            }

            if ($status >= 500 && view()->exists('errors.5xx')) {
                return response()->view('errors.5xx', [
                    'exception' => $e,
                ], $status);
            }

            return $response;
        });
    })->create();
