<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        /**
         * Unauthenticated users are redirected to login
         */
        $middleware->redirectGuestsTo(fn (Request $request) => route('login'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        /**
         * Rate limiting — JSON for API routes, redirect with flash for web
         */
        $exceptions->render(function (\Illuminate\Http\Exceptions\ThrottleRequestsException $e, Request $request) {
            $seconds = (int) $e->getHeaders()['Retry-After'];
            $minutes = ceil($seconds / 60);
            $message = $seconds >= 60
                ? "Too many attempts. Please try again in {$minutes} minute(s)."
                : "Too many attempts. Please try again in {$seconds} second(s).";

            if ($request->expectsJson()) {
                return response()->json(['status' => 'error', 'message' => $message], 429);
            }

            return back()->withErrors(['throttle' => $message]);
        });

        /**
         * Validation errors — JSON for API routes, redirect with errors for web
         */
        $exceptions->render(function (\Illuminate\Validation\ValidationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Validation failed.',
                    'errors'  => $e->errors(),
                ], 422);
            }

            return back()->withErrors($e->errors())->withInput();
        });
    })
    ->booted(function () {
        /**
         * Rate limiting — API routes only
         */
        RateLimiter::for('api', function ($request) {
            return Limit::perMinute(60)->by(
                $request->user()?->id ?: $request->ip()
            );
        });
    })
    ->create();