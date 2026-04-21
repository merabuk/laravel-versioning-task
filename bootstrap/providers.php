<?php

use App\App\Api\ApiServiceProvider;
use App\Core\Versioning\Providers\VersioningServiceProvider;
use App\Domain\Company\Providers\CompanyServiceProvider;
use App\Infrastructure\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    ApiServiceProvider::class,
    CompanyServiceProvider::class,
    VersioningServiceProvider::class,
];
