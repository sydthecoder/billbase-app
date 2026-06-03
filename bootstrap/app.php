<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append([
            \Illuminate\Http\Middleware\HandleCors::class,
            \App\Http\Middleware\AttachAuthTokenFromCookie::class,
        ]);
    })
    /* Rate limit friendly message */
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Http\Exceptions\ThrottleRequestsException $e, $request) {
            $seconds = (int) $e->getHeaders()['Retry-After'];
            
            if ($seconds >= 60) {
                $minutes = ceil($seconds / 60);
                $message = "Too many attempts. Please try again in {$minutes} minute(s).";
            } else {
                $message = "Too many attempts. Please try again in {$seconds} second(s).";
            }

            return response()->json([
                'status'  => 'error',
                'message' => $message,
            ], 429);
        });
    })
    /* Rate limit default for all api routes */
    ->booted(function () {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(
                $request->user()?->id ?: $request->ip()
            );
        });
    })
    ->create();
