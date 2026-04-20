<?php

declare(strict_types=1);

namespace App\Core\Versioning\Contracts;

use App\Core\Versioning\Models\Version;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @mixin Model
 */
interface Versionable
{
    public function versions(): MorphMany;

    public function latestVersion(): ?Version;

    public function getVersioningFields(): array;

    public function toSnapshot(): array;
}
