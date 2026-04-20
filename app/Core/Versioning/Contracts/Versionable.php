<?php

declare(strict_types=1);

namespace App\Core\Versioning\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @mixin Model
 */
interface Versionable
{
    public function versions(): MorphMany;

    public function latestVersion(): MorphOne;

    public function getVersioningFields(): array;

    public function toSnapshot(): array;
}
