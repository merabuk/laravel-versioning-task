<?php

use App\App\Api\V1\Exceptions\Handler as ApiV1Handler;
use App\Infrastructure\Exceptions\Handler as InfrastructureHandler;
use App\Infrastructure\Middleware\SetAppLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(append: [
            SetAppLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, $request) {
            if ($request->is('api/v1/*')) {
                return new ApiV1Handler(app())->render($request, $e);
            }

            if ($request->is('api/*')) {
                return new InfrastructureHandler(app())->render($request, $e);
            }

            return null;
        });
    })->create();
