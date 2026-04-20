<?php

declare(strict_types=1);

namespace App\App\Api;

use App\Infrastructure\Middleware\AddAcceptJsonHeader;
use App\Infrastructure\Middleware\TrimSpacesMiddleware;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    private const string V1_ROUTES = __DIR__ . '/V1/routes.php';

    public function boot(): void
    {
        $this->registerV1Routes();
    }

    private function registerV1Routes(): void
    {
        Route::prefix('api/v1')
            ->middleware([
                'api',
                SubstituteBindings::class,
                AddAcceptJsonHeader::class,
                TrimSpacesMiddleware::class,
                ThrottleRequests::class . ':api',
            ])
            ->group(self::V1_ROUTES);
    }
}
