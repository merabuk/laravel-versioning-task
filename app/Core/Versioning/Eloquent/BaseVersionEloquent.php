<?php

declare(strict_types=1);

namespace App\Core\Versioning\Eloquent;

use App\Core\Versioning\Models\Version;

abstract class BaseVersionEloquent
{
    public function __construct(
        protected Version $model
    ) {}
}
