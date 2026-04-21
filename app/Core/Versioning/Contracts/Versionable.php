<?php

declare(strict_types=1);

namespace App\Core\Versioning\Contracts;

use App\Core\Versioning\Models\Version;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @mixin Model
 */
interface Versionable
{
    /**
     * @return MorphMany<Version, Model&Versionable>
     */
    public function versions(): MorphMany;

    /**
     * @return MorphOne<Version, Model&Versionable>
     */
    public function latestVersion(): MorphOne;

    /**
     * @return string[]
     */
    public function getVersioningFields(): array;

    /**
     * @return array<string, mixed>
     */
    public function toSnapshot(): array;
}
