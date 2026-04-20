<?php

declare(strict_types=1);

namespace App\Core\Versioning\Traits;

use App\Core\Versioning\Models\Version;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property Collection<int, Version> $versions
 * @property ?Version $latestVersion
 *
 * @mixin Model
 */
trait HasVersions
{
    public function versions(): MorphMany
    {
        return $this->morphMany(Version::class, 'versionable');
    }

    public function latestVersion(): ?Version
    {
        return $this->versions()->latest('version')->first();
    }

    abstract public function getVersioningFields(): array;

    public function toSnapshot(): array
    {
        return $this->only($this->getVersioningFields());
    }
}
