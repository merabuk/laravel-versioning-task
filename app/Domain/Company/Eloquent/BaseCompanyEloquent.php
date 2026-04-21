<?php

declare(strict_types=1);

namespace App\Domain\Company\Eloquent;

use App\Domain\Company\Models\Company;

abstract class BaseCompanyEloquent
{
    public function __construct(
        protected Company $model
    ) {
    }
}
