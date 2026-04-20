<?php

declare(strict_types=1);

namespace App\Core\Versioning\Enums;

enum StatusEnum: string
{
    case Created = 'created';
    case Updated = 'updated';
    case Duplicate = 'duplicate';
}
