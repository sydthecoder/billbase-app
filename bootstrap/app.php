<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        /**
         * If no token stop redirect to default laravel login web route
         * Instead throw 401 error
         */
        $middleware->redirectGuestsTo(fn (Request $request) => null);

        $middleware->append([
            \Illuminate\Http\Middleware\HandleCors::class,
            \App\Http\Middleware\AttachAuthTokenFromCookie::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        /**
         * Default rate limitting across most generic routes
         */
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

        /**
         * Returns 422 and its specific errors instead of redirecting and throwing 404
         */
        $exceptions->render(function (\Illuminate\Validation\ValidationException $e, Request $request) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation failed.',
                'errors'  => $e->errors(),
            ], 422);
        });
    })
    
    /**
     * Apply the rate limitting
     */
    ->booted(function () {
        RateLimiter::for('api', function ($request) {
            return Limit::perMinute(60)->by(
                $request->user()?->id ?: $request->ip()
            );
        });
    })
    ->create();