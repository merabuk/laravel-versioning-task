<?php

declare(strict_types=1);

namespace App\Core\Versioning\Exceptions;

use App\Exceptions\EntityFindException;

class VersionFindException extends EntityFindException
{
    protected string $entityName = 'version';
}
