<?php

declare(strict_types=1);

namespace App\Core\Versioning\Traits;

use App\Core\Versioning\Contracts\Versionable;
use App\Core\Versioning\Models\Version;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @property Collection<int, Version> $versions
 * @property ?Version $latestVersion
 *
 * @mixin Model
 */
trait HasVersions
{
    /**
     * @return MorphMany<Version, Model&Versionable>
     */
    public function versions(): MorphMany
    {
        /** @var MorphMany<Version, Model&Versionable> $relation */
        $relation = $this->morphMany(Version::class, 'versionable')->latest('version');

        return $relation;
    }

    /**
     * @return MorphOne<Version, Model&Versionable>
     */
    public function latestVersion(): MorphOne
    {
        /** @var MorphOne<Version, Model&Versionable> $relation */
        $relation = $this->versions()->one()->latestOfMany();

        return $relation;
    }

    /**
     * @return string[]
     */
    abstract public function getVersioningFields(): array;

    /**
     * @return array<string, mixed>
     */
    public function toSnapshot(): array
    {
        return $this->only($this->getVersioningFields());
    }
}
