<?php

declare(strict_types=1);

namespace App\Domain\Company\Exceptions;

use App\Infrastructure\Exceptions\EntityFindException;

class CompanyFindException extends EntityFindException
{
    protected string $entityName = 'company';
}
