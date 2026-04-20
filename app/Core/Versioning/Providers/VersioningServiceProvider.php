<?php

declare(strict_types=1);

namespace App\Core\Versioning\Providers;

use Illuminate\Support\ServiceProvider;

class VersioningServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
